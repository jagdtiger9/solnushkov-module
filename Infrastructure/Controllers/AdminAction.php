<?php

namespace Aljerom\Solnushkov\Infrastructure\Controllers;

use App\DomainModel\ValueObject\EmailVO;
use DateTimeImmutable;
use Exception;
use MagicPro\Application\Context\RequestContextInterface;
use MagicPro\Application\Controller;
use MagicPro\Config\Config;
use MagicPro\Contracts\MailInterface;
use MagicPro\DomainModel\ORM\EntityManagerInterface;
use MagicPro\Http\Api\ErrorResponse;
use MagicPro\Http\Api\SuccessResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use sendmail\Domain\Models\Letter;
use sendmail\Domain\Models\Recipient;
use sessauth\Domain\Repository\UserRepositoryInterface;
use sessauth\Domain\Service\SecretString;

class AdminAction extends Controller
{
    public function actionRestoreLetters(ServerRequestInterface $request, RequestContextInterface $context): ResponseInterface
    {
        try {
            if (false === $period = $context->getVeryUglyOldGet('restorePeriod')) {
                throw new \InvalidArgumentException('Не задан период восстановления писем');
            }

            if (!is_numeric($period) || !$period) {
                throw new \InvalidArgumentException('Период должен быть числом, больше 0');
            }

            $fromTime = (new \DateTime())
                ->sub(new \DateInterval('P' . $period . 'D'))
                ->format('Y-m-d H:i:s');
            $toTime = (new \DateTime())->format('Y-m-d H:i:s');

            $recipients = Recipient::whereBetween('sendAfterTime', [$fromTime, $toTime])->get();
            $count = 0;
            if (\count($recipients)) {
                $config = Config::get('sendmail');

                $letters = array_reduce(
                    $recipients,
                    function ($carry, $item) use ($config) {
                        $carry[] = ['uid' => $item->letterId, 'senderEmail' => $config['from']];

                        return $carry;
                    },
                    []
                );
                $letter = new Letter();
                $letter->insertOrUpdate($letters);

                foreach ($recipients as $recipient) {
                    $recipient->forceSend()
                        ->restoreQueue()
                        ->save();
                }
            }
            $apiResponse = new SuccessResponse($count . ' писем успешно возвращены в очередь на отправку');
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect());
    }

    public function actionSend(
        ServerRequestInterface $request,
        UserRepositoryInterface $userRepo,
        SecretString $secret,
        EntityManagerInterface $entityManager,
        MailInterface $mailer,
    ): ResponseInterface {
        try {
            if (!$email = $request->getParsedBody()['email'] ?? '') {
                throw new \InvalidArgumentException('Не указан email получателя');
            }
            if (!$user = $userRepo->getByEmail(new EmailVO(htmlspecialchars($email)))) {
                throw new \UnexpectedValueException('Учетной записи с указанным email не найдено');
            }
            if (!$title = $request->getParsedBody()['title'] ?? '') {
                throw new \InvalidArgumentException('Не указан заголовок сообщения');
            }
            if (!$message = $request->getParsedBody()['message'] ?? '') {
                throw new \InvalidArgumentException('Не указано тело сообщения');
            }
            $pass = $user->newPassRequestHash($secret, new DateTimeImmutable());
            $entityManager->persist($user);
            $entityManager->run();

            if (!$mailer->addParams(['password' => $pass])->send($user->email(), $title, $message)) {
                throw new \RuntimeException('Ошибка отправки письма. ' . $mailer->error());
            }
            $this->flash->set('msg', 'Письмо успешно отправлено', 'success');
        } catch (\Exception $e) {
            $this->flash->set('msg', $e->getMessage(), 'danger');
        }

        return $this->response->redirectBack();
    }
}
