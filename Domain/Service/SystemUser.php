<?php

namespace Aljerom\Solnushkov\Domain\Service;

use Aljerom\Solnushkov\Domain\Entity\SystemUserDto;
use MagicPro\Contracts\Database\DatabaseInterface;

class SystemUser
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @param string $email
     * @return SystemUserDto|null
     */
    public function getUserByEmail(string $email): ?SystemUserDto
    {
        $result = $this->database->select()
            ->columns(['u.uid', 'u.email', 'u.active'])
            ->from('SA__user as u')
            ->where('email', $email)
            ->fetchAll();

        return $result ? new SystemUserDto($result[0]['uid'], $result[0]['email'], $result[0]['active']) : null;
    }
}
