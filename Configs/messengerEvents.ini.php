<?php

use Aljerom\Solnushkov\Application\EventHandler\TgAuthenticateHandler;
use telegram\Domain\Event\TgUserRegistered;

return [
    TgUserRegistered::class => [
        TgAuthenticateHandler::class,
    ],
];
