<?php

use sessauth\Application\EventHandler\AuthenticateUserHandler;
use sessauth\Application\EventHandler\CreateValidatedUserHandler;

return [
    Aljerom\Solnushkov\Domain\Event\TempUserValidated::class => [
        [CreateValidatedUserHandler::class, '__invoke']
    ],
    Aljerom\Solnushkov\Domain\Event\SystemUserCreated::class => [
        [AuthenticateUserHandler::class, '__invoke']
    ],
];
