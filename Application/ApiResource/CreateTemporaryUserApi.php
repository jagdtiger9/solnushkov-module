<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use App\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Aljerom\Solnushkov\Application\Command\CreateTemporaryUserCommand;
use Psr\Http\Message\ServerRequestInterface;

class CreateTemporaryUserApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Проверяет нет ли такого email в базе и если нет
записывает куда-то информацию "email" и "пароль"
STR;
    }

    public function getValidatedMessage(
        ServerRequestInterface    $request,
        ValidatedMessageInterface $validatedMessage
    ): CreateTemporaryUserCommand {
        return $validatedMessage->fromRequest($this->inputParam(), $request);
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
