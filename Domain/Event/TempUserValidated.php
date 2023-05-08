<?php

namespace Aljerom\Solnushkov\Domain\Event;

use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;

class TempUserValidated
{
    private string $email;

    private string $password;

    public function __construct(TemporaryUser $tempUser)
    {
        $this->email = $tempUser->email();
        $this->password = $tempUser->password();
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
