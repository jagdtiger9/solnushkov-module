<?php

namespace Aljerom\Solnushkov\Infrastructure\ViewHelpers;

use App\Application\FrameworkConfig;
use MagicPro\Contracts\Session\SessionInterface;
use MagicPro\Contracts\User\SessionUserInterface;
use MagicPro\View\ViewHelper\AbstractViewHelper;
use Psr\Container\ContainerInterface;
use sessauth\Domain\ReadModel\UserDTO;

/**
 * Включение-выключение админского контекста сессий
 */
class AdminContext extends AbstractViewHelper
{
    private static ?SessionUserInterface $savedContext = null;

    public function __construct(
        private SessionInterface $session,
        private SessionUserInterface $user,
        private ContainerInterface $container,
        private FrameworkConfig $config
    ) {
    }

    /**
     * Список параметров, которые принимает ViewHelper с указанием соответствующих дефолтных значений
     * @return array
     */
    public function defaultParams(): array
    {
        return [
            'mode' => [
                'value' => 'off',
                'comment' => 'Режим: on или off',
                'filter' => ['on', 'off'],
            ],
        ];
    }

    public function getData()
    {
        if ($this->params['mode'] === 'on' && null === self::$savedContext) {
            self::$savedContext = $this->user;
            $user = UserDTO::fromArray(
                [
                    'uid' => 1,
                    'login' => 'admin',
                    'active' => 1,
                ]
            );
            $this->container->set(SessionUserInterface::class, $user);
        }

        if ($this->params['mode'] === 'off' && self::$savedContext) {
            $this->container->set(SessionUserInterface::class, self::$savedContext);
            self::$savedContext = null;
        }

        return [
            'msg' => 'AdminContext' . (self::$savedContext ? ' активирован' : ' отключен'),
            'session' => $this->session->all(),
        ];
    }

    public function getPresetTemplates(): array
    {
        return [];
    }
}
