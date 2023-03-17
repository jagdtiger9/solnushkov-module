<?php

namespace Aljerom\Solnushkov\Domain\Event;

use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;
use MagicPro\DomainModel\Dto\Dto;

class SystemUserCreated implements Dto
{
    public string $email;

    public function __construct(TemporaryUser $tempUser)
    {
        $this->email = $tempUser->email();
    }
}
