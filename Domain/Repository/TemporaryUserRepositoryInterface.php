<?php

namespace Aljerom\Solnushkov\Domain\Repository;

use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;

interface TemporaryUserRepositoryInterface
{
    /**
     * @param string $email
     * @return TemporaryUser|null
     */
    public function getByEmail(string $email): ?TemporaryUser;

    /**
     * @param string $email
     * @param string $password
     * @return TemporaryUser|null
     */
    public function getByEmailPass(string $email, string $password): ?TemporaryUser;

    /**
     * @param TemporaryUser $email
     */
    public function save(TemporaryUser $email): void;
}
