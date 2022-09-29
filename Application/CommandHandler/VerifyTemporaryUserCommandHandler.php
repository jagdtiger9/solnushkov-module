<?php

namespace Aljerom\Solnushkov\Application\CommandHandler;

use MagicPro\DomainModel\Entity\DomainEventStoreTrait;
use MagicPro\DomainModel\Event\DomainEventStore;
use MagicPro\Event\Event;
use MagicPro\Messenger\Handler\MessageHandlerInterface;
use phorum\Domain\Exception\RuntimeException;
use Aljerom\Solnushkov\Application\Command\VerifyTemporaryUserCommand;
use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;
use Aljerom\Solnushkov\Domain\Service\SystemUser;

class VerifyTemporaryUserCommandHandler implements MessageHandlerInterface
{
    use DomainEventStoreTrait;

    public function __construct(
        private Event                            $event,
        private TemporaryUserRepositoryInterface $tempUserRepo,
        private SystemUser                       $systemUser,
        DomainEventStore                         $domainEventStore,
    ) {
        $this->domainEventStore = $domainEventStore;
    }

    public function __invoke(VerifyTemporaryUserCommand $command): void
    {
        if (!$tempUser = $this->tempUserRepo->getByEmailPass($command->email, $command->password)) {
            throw new RuntimeException('Временный пользователь с указанным email-pass не существует');
        }

        // Пишем события для проверки-создания системного пользователя и авторизации
        $tempUser->setValidated($this->systemUser);

        $this->entityEventStore($tempUser);
    }
}
