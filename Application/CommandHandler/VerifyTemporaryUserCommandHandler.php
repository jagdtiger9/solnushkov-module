<?php

namespace Aljerom\Solnushkov\Application\CommandHandler;

use MagicPro\DomainModel\Entity\ReleaseEventTrait;
use MagicPro\Event\Event;
use MagicPro\Messenger\Handler\MessageHandlerInterface;
use phorum\Domain\Exception\RuntimeException;
use Aljerom\Solnushkov\Application\Command\VerifyTemporaryUserCommand;
use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;
use Aljerom\Solnushkov\Domain\Service\SystemUser;

class VerifyTemporaryUserCommandHandler implements MessageHandlerInterface
{
    use ReleaseEventTrait;

    protected Event $event;

    private TemporaryUserRepositoryInterface $tempUserRepo;

    private SystemUser $systemUser;

    public function __construct(
        Event                            $event,
        TemporaryUserRepositoryInterface $tempUserRepo,
        SystemUser                       $systemUser
    ) {
        $this->tempUserRepo = $tempUserRepo;
        $this->systemUser = $systemUser;
        $this->event = $event;
    }

    /**
     * @param VerifyTemporaryUserCommand $command
     */
    public function __invoke(VerifyTemporaryUserCommand $command): void
    {
        if (!$tempUser = $this->tempUserRepo->getByEmailPass($command->email, $command->password)) {
            throw new RuntimeException('Временный пользователь с указанным email-pass не существует');
        }

        // Пишем события для проверки-создания системного пользователя и авторизации
        $tempUser->setValidated($this->systemUser);

        $this->releaseEvents($tempUser);
    }
}
