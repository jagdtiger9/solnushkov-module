<?php

namespace Aljerom\Solnushkov\Domain\Entity;

use Aljerom\Solnushkov\Domain\Event\SystemUserCreated;
use Aljerom\Solnushkov\Domain\Event\TempUserValidated;
use Aljerom\Solnushkov\Domain\Service\SystemUser;
use MagicPro\DDD\Entity\AggregateRoot;

class TemporaryUser extends AggregateRoot
{
    /**
     * @var int
     */
    private $isNew = 0;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $createTime;

    public function __construct(string $email, string $password, int $isNew = 0)
    {
        $this->email = $email;
        $this->password = $password;
        $this->createTime = time();
        $this->isNew = $isNew;
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function createTime(): int
    {
        return $this->createTime;
    }

    public function isNew(): bool
    {
        return $this->isNew;
    }

    public function setValidated(SystemUser $systemUser): void
    {
        if (!$systemUser->getUserByEmail($this->email)) {
            $this->recordEvent(new TempUserValidated($this));
        }
        $this->recordEvent(new SystemUserCreated($this));
    }
}
