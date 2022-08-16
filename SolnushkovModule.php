<?php

namespace Aljerom\Solnushkov;

use MagicPro\PluginModules\Module\AbstractModule;

class SolnushkovModule extends AbstractModule
{
    public function modulePath(): string
    {
        return __DIR__;
    }

    public function getTitle(): string
    {
        return 'Каталог';
    }

    public function getIconPath(): string
    {
        return realpath($this->modulePath . '/' . AbstractModule::MODULE_ICON);
    }

}
