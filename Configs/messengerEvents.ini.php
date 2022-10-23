<?php

return [
    telegram\Domain\Event\TgUserRegistered::class => [
        Aljerom\Solnushkov\Application\EventHandler\TgAuthenticateHandler::class,
    ],
    Aljerom\Solnushkov\Domain\Event\TempUserValidated::class => [
        sessauth\Application\EventHandler\CreateValidatedUserHandler::class,
    ],
    Aljerom\Solnushkov\Domain\Event\SystemUserCreated::class => [
        sessauth\Application\EventHandler\AuthenticateUserHandler::class,
    ],
];
