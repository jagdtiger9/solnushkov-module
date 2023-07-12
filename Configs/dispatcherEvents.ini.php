<?php

return [
    Aljerom\Solnushkov\Domain\Event\SystemUserCreated::class => [
        [sessauth\Application\EventHandler\AuthenticateUserHandler::class, '__invoke'],
    ],
    Aljerom\Solnushkov\Domain\Event\TempUserValidated::class => [
        [sessauth\Application\EventHandler\CreateValidatedUserHandler::class, '__invoke'],
    ],
];
