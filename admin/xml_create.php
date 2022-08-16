<?php

use dumpsite\Models\Dump;

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `sol__emailUser` (
    `email` varchar(255) NOT NULL default '',
    `password` varchar(255) NOT NULL default '',
    `userId` integer NOT NULL default '0' COMMENT 'ID пользователя',
    `createTime` integer NOT NULL default '0' COMMENT 'Время создания',
UNIQUE `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;
Dump::createTable('sol__emailUser', $sql);
