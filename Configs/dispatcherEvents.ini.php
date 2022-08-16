<?php

use Aljerom\Solnushkov\Domain\Event\SystemUserCreated;
use Aljerom\Solnushkov\Domain\Event\TempUserValidated;
use sessauth\Application\EventHandler\AuthenticateUserHandler;
use sessauth\Application\EventHandler\CreateValidatedUserHandler;

return [
    TempUserValidated::class => [
        [CreateValidatedUserHandler::class, 'handle']
    ],
    SystemUserCreated::class => [
        [AuthenticateUserHandler::class, 'handle']
    ],
];
