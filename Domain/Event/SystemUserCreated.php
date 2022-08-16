<?php

namespace Aljerom\Solnushkov\Domain\Event;

use MagicPro\DomainModel\Dto\Dto;
use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;

class SystemUserCreated implements Dto
{
    /**
     * @var string
     */
    private $email;

    public function __construct(TemporaryUser $tempUser)
    {
        $this->email = $tempUser->email();
    }

    public function email(): string
    {
        return $this->email;
    }
}
