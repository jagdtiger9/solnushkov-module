<?php

namespace Aljerom\Solnushkov\Infrastructure\Persistence\MySQL;

use MagicPro\Contracts\Database\DatabaseInterface;
use Aljerom\Solnushkov\Domain\Entity\TemporaryUser;
use Aljerom\Solnushkov\Domain\Repository\TemporaryUserRepositoryInterface;

class TemporaryUserRepository implements TemporaryUserRepositoryInterface
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function getByEmail(string $email): ?TemporaryUser
    {
        $tempUserRows = $this->database->select()
            ->from('sol__emailUser')
            ->where('email', $email)
            ->fetchAll();
        if (!$tempUserRows) {
            return null;
        }

        return new TemporaryUser($tempUserRows[0]['email'], $tempUserRows[0]['password']);
    }

    public function getByEmailPass(string $email, string $password): ?TemporaryUser
    {
        $tempUserRows = $this->database->select()
            ->from('sol__emailUser')
            ->where(
                [
                    'email' => $email,
                    'password' => $password,
                ]
            )
            ->fetchAll();
        if (!$tempUserRows) {
            return null;
        }

        return new TemporaryUser($tempUserRows[0]['email'], $tempUserRows[0]['password']);
    }

    public function save(TemporaryUser $tempUser): void
    {
        $builder = $this->database->table('sol__emailUser');
        if ($tempUser->isNew()) {
            $builder->insertOne(
                [
                    'email' => $tempUser->email(),
                    'password' => $tempUser->password(),
                    'createTime' => $tempUser->createTime(),
                ]
            );
        } else {
            $builder->update(['password' => $tempUser->password()])
                ->where('email', $tempUser->email())
                ->run();
        }
    }
}
