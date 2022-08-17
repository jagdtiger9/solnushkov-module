<?php

namespace Aljerom\Solnushkov;

use MagicPro\PluginModules\Module\AbstractModule;

class SolnushkovModule extends AbstractModule
{
    public function modulePath(): string
    {
        return __DIR__;
    }

    public function getName(): string
    {
        return 'solnushkov';
    }

    public function getTitle(): string
    {
        return 'Solnushkov';
    }
}
