<?php

namespace Aljerom\Solnushkov\Domain\Entity\Identity;

use MagicPro\DomainModel\Entity\Identity\IntegerIdentity;
use Webmozart\Assert\Assert;

class UserId extends IntegerIdentity
{
    public function __construct(int $uid = 0)
    {
        Assert::greaterThan($uid, 0, 'Идентификатор пользователя должен быть больше нуля, %s');
        parent::__construct($uid);
    }
}
