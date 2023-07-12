<?php

namespace Aljerom\Solnushkov\Application\CommandHandler;

use Aljerom\Solnushkov\Application\Command\VerifyTemporaryUserCommand;
use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;
use Aljerom\Solnushkov\Domain\Service\SystemUser;
use MagicPro\Event\EventDispatcherInterface;
use MagicPro\Messenger\Handler\MessageHandlerInterface;
use phorum\Domain\Exception\RuntimeException;

class VerifyTemporaryUserCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private TemporaryUserRepositoryInterface $tempUserRepo,
        private SystemUser $systemUser,
    ) {
    }

    public function __invoke(VerifyTemporaryUserCommand $command): void
    {
        if (!$tempUser = $this->tempUserRepo->getByEmailPass($command->email, $command->password)) {
            throw new RuntimeException('Временный пользователь с указанным email-pass не существует');
        }
        // Пишем события для проверки-создания системного пользователя и авторизации
        $tempUser->setValidated($this->systemUser);

        $domainEvents = $tempUser->releaseDomainEvents();
        foreach ($domainEvents as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
