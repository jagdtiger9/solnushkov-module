<?php

namespace Aljerom\Solnushkov\Domain\Service;

use MagicPro\Contracts\Database\DatabaseNewInterface;
use Aljerom\Solnushkov\Domain\Entity\Identity\UserId;

class SystemUser
{
    private DatabaseNewInterface $database;

    public function __construct(DatabaseNewInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @param string $email
     * @return UserId|null
     */
    public function getUserByEmail(string $email): ?UserId
    {
        $result = $this->database->select()
            ->columns(['u.uid', 'u.email'])
            ->from('SA__user as u')
            ->where('email', $email)
            ->fetchAll();

        return $result ? new UserId($result[0]['uid']) : null;
    }
}
