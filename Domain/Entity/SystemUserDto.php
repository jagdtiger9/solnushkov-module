<?php

namespace Aljerom\Solnushkov\Domain\Entity;

class SystemUserDto
{
    public function __construct(
        public int    $uid,
        public string $email,
        public int    $active
    ) {
    }
}
