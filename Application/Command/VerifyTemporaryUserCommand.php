<?php

namespace Aljerom\Solnushkov\Application\Command;

use MagicPro\Messenger\Message\CommandInterface;
use MagicPro\Messenger\Validation\MessageValidatedInterface;
use MagicPro\Messenger\Validation\MessageValidatedTrait;
use MagicPro\DDD\SimpleDto\SimpleDto;
use Aljerom\Solnushkov\Application\CommandHandler\VerifyTemporaryUserCommandHandler;

class VerifyTemporaryUserCommand extends SimpleDto implements CommandInterface, MessageValidatedInterface
{
    use MessageValidatedTrait;

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
        return VerifyTemporaryUserCommandHandler::class;
    }
}
