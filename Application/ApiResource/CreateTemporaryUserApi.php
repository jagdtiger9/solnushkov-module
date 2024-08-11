<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use Aljerom\Solnushkov\Application\Command\CreateTemporaryUserCommand;
use MagicPro\Api\AbstractApiResource;

class CreateTemporaryUserApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Проверяет нет ли такого email в базе и если нет
записывает куда-то информацию "email" и "пароль"
STR;
    }

    public function inputParam(): string
    {
        return CreateTemporaryUserCommand::class;
    }

    public function outputParam(): string
    {
        return 'Строка результат операции';
    }
}
