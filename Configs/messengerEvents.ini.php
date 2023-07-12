<?php

return [
    telegram\Domain\Event\TgUserRegistered::class => [
        Aljerom\Solnushkov\Application\EventHandler\TgAuthenticateHandler::class,
    ],
];
