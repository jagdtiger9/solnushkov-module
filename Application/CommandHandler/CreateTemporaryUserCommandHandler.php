<?php

namespace Aljerom\Solnushkov\Application\CommandHandler;

use MagicPro\Messenger\Handler\MessageHandlerInterface;
use Aljerom\Solnushkov\Application\Command\CreateTemporaryUserCommand;
use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;
use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;
use Aljerom\Solnushkov\Domain\Service\SystemUser;

class CreateTemporaryUserCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private TemporaryUserRepositoryInterface $tempUserRepo,
        private SystemUser                       $systemUser,
    ) {
    }

    /**
     * @param CreateTemporaryUserCommand $command
     */
    public function __invoke(CreateTemporaryUserCommand $command): void
    {
        if (($user = $this->systemUser->getUserByEmail($command->email)) && $user->active) {
            throw new \InvalidArgumentException('Пользователь уже активирован');
        }

        if ($temporaryUser = $this->tempUserRepo->getByEmail($command->email)) {
            $temporaryUser->changePassword($command->password);
        } else {
            $temporaryUser = new TemporaryUser($command->email, $command->password, 1);
        }

        $this->tempUserRepo->save($temporaryUser);
    }
}
