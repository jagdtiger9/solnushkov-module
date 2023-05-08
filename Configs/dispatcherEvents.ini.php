<?php

use sessauth\Application\EventHandler\AuthenticateUserHandler;

return [
    Aljerom\Solnushkov\Domain\Event\SystemUserCreated::class => [
        [AuthenticateUserHandler::class, '__invoke']
    ],
];
