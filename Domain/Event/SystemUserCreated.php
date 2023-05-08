<?php

namespace Aljerom\Solnushkov\Domain\Event;

use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;

class SystemUserCreated
{
    public string $email;

    public function __construct(TemporaryUser $tempUser)
    {
        $this->email = $tempUser->email();
    }
}
