<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use Aljerom\Solnushkov\Application\Command\VerifyTemporaryUserCommand;
use MagicPro\Api\AbstractApiResource;

class VerifyTemporaryUserApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Проверяет, есть ли такой юзер и совпадает ли пароль.
Если совпадает, то авторизует юзера и заводит нормальную учетку
STR;
    }

    public function inputParam(): string
    {
        return VerifyTemporaryUserCommand::class;
    }

    public function outputParam(): string
    {
        return 'Пустая строка';
    }
}
