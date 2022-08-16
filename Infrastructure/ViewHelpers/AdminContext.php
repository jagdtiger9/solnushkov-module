<?php

namespace Aljerom\Solnushkov\Infrastructure\ViewHelpers;

use App\Application\FrameworkConfig;
use MagicPro\Contracts\Session\SessionInterface;
use MagicPro\Session\Handler\ArrayHandler;
use MagicPro\Session\Session;
use MagicPro\Session\Storage\ArrayStorage;
use MagicPro\View\ViewHelper\AbstractViewHelper;
use Psr\Container\ContainerInterface;

/**
 * Включение-выключение админского контекста сессий
 */
class AdminContext extends AbstractViewHelper
{
    private static $savedContext;

    private SessionInterface $session;

    private ContainerInterface $container;

    private FrameworkConfig $config;

    public function __construct(
        SessionInterface $session,
        ContainerInterface $container,
        FrameworkConfig $config
    ) {
        $this->session = $session;
        $this->container = $container;
        $this->config = $config;
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

    /**
     * Пустой элемент - логический разделитель
     * @return array
     */
    public function getData()
    {
        if ($this->params['mode'] === 'on' && null === self::$savedContext) {
            self::$savedContext = $this->session;
            $storage = new ArrayStorage(
                [
                    'login' => 'admin',
                    'userid' => 1,
                    'userGroups' => [
                        0 => 1,
                        1 => 2,
                    ],
                    'active' => 1,
                    'isAuth' => 1,
                ]
            );
            $session = new Session(new ArrayHandler(), $storage, $this->config->getDbName());
            $this->container->set(SessionInterface::class, $session);
        }

        if ($this->params['mode'] === 'off' && self::$savedContext) {
            $this->container->set(SessionInterface::class, self::$savedContext);
            self::$savedContext = null;
        }

        return [
            'msg' => 'AdminContext' . (self::$savedContext ? ' активирован' : ' отключен'),
            'session' => $this->session->all(),
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function getPresetTemplates(): array
    {
        return [];
    }
}
