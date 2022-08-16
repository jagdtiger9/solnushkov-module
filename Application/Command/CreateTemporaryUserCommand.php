<?php

namespace Aljerom\Solnushkov\Application\Command;

use MagicPro\Messenger\Message\CommandInterface;
use MagicPro\Messenger\Validation\MessageValidationInterface;
use MagicPro\Messenger\Validation\MessageValidationTrait;
use MagicPro\DomainModel\Dto\SimpleDto;
use Aljerom\Solnushkov\Application\CommandHandler\CreateTemporaryUserCommandHandler;

class CreateTemporaryUserCommand extends SimpleDto implements CommandInterface, MessageValidationInterface
{
    use MessageValidationTrait;

    /**
     * Email пользователя
     * @var string
     */
    public $email;

    /**
     * Пароль
     * @var string
     */
    public $password;

    public function __construct(string $email = '', string $password = '')
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc',
            'password' => 'required|string',
        ];
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getHandlerClassName(): string
    {
        return CreateTemporaryUserCommandHandler::class;
    }
}
