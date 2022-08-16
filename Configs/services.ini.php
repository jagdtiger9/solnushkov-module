<?php

use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;
use Aljerom\Solnushkov\Infrastructure\Persistence\MySQL\TemporaryUserRepository;

return [
    TemporaryUserRepositoryInterface::class => TemporaryUserRepository::class,
];
