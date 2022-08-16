<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use App\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Aljerom\Solnushkov\Application\Command\VerifyTemporaryUserCommand;
use Psr\Http\Message\ServerRequestInterface;

class VerifyTemporaryUserApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Проверяет, есть ли такой юзер и совпадает ли пароль.
Если совпадает, то авторизует юзера и заводит нормальную учетку
STR;
    }

    public function getValidatedMessage(ServerRequestInterface $request, ValidatedMessageInterface $validatedMessage): VerifyTemporaryUserCommand
    {
        return $validatedMessage->fromRequest($this->inputParam(), $request);
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
