<?php

namespace Aljerom\Solnushkov\Infrastructure\Controllers;

use Exception;
use MagicPro\Config\Config;
use MagicPro\Application\Controller;
use MagicPro\Contracts\MailInterface;
use MagicPro\Http\Api\ErrorResponse;
use MagicPro\Http\Api\SuccessResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use sendmail\Domain\Models\Letter;
use sendmail\Domain\Models\Recipient;
use sessauth\Domain\Models\User;

class AdminAction extends Controller
{
    public function actionRestoreLetters(ServerRequestInterface $request): ResponseInterface
    {
        try {
            if (false === $period = $request->Get('restorePeriod')) {
                throw new \InvalidArgumentException('Не задан период восстановления писем');
            }

            if (!is_numeric($period) || !$period) {
                throw new \InvalidArgumentException('Период должен быть числом, больше 0');
            }

            $fromTime = (new \DateTime())
                ->sub(new \DateInterval('P' . $period . 'D'))
                ->format('Y-m-d H:i:s');
            $toTime = (new \DateTime())->format('Y-m-d H:i:s');

            $recipients = Recipient::whereBetween('lastTrialTime', [$fromTime, $toTime])->get();
            $count = 0;
            if (\count($recipients)) {
                $config = Config::get('sendmail');

                $letters = array_reduce(
                    $recipients,
                    function ($carry, $item) use ($config) {
                        $carry[] = ['uid' => $item->letterId, 'senderEmail' => $config->settings['from']];

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

    public function actionSend(ServerRequestInterface $request, MailInterface $mailer): ResponseInterface
    {
        try {
            if (!($email = $request->Post('email'))) {
                throw new \InvalidArgumentException('Не указан email получателя');
            }

            if (!count($users = User::where('email', htmlspecialchars($email))->get())) {
                throw new \UnexpectedValueException('Учетной записи с указанным email не найдено');
            }
            if (count($users) > 1) {
                throw new \UnexpectedValueException('Найдено более одной учетной записи с указанным email');
            }

            if (!($title = $request->Post('title'))) {
                throw new \InvalidArgumentException('Не указан заголовок сообщения');
            }

            if (!($message = $request->Post('message'))) {
                throw new \InvalidArgumentException('Не указано тело сообщения');
            }

            $newPassword = $users[0]->requestNewPass();
            if (false === $users[0]->save()) {
                throw new \RuntimeException('Ошибка создания нового пароля');
            }

            if (!$mailer->addParams(['password' => $newPassword])->send($users[0]->email, $title, $message)) {
                throw new \RuntimeException('Ошибка отправки письма. ' . $mailer->error());
            }

            $this->flash->set('msg', 'Письмо успешно отправлено', 'success');
        } catch (\Exception $e) {
            $this->flash->set('msg', $e->getMessage(), 'danger');
        }

        return $this->response->redirectBack();
    }
}
