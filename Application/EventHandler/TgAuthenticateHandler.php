<?php

namespace Aljerom\Solnushkov\Application\EventHandler;

use MagicPro\Contracts\Logger\LoggerInterface;
use MagicPro\View\View;
use telegram\Domain\Event\TgUserAuthenticated;

class TgAuthenticateHandler
{
    public function __construct(
        private View            $view,
        private LoggerInterface $logger,
    ) {
    }

    public function handle(TgUserAuthenticated $event): void
    {
        if (!$event->isNew()) {
            return;
        }

        try {
            $result = $this->view
                ->make()
                ->setClientFinder()
                ->setTemplate('telegramUserAuthenticated')
                ->render([
                    'userId' => $event->userId(),
                    'tgUserId' => $event->telegramUserId(),
                ]);
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }
        $this->logger
            ->setLog('telegramUserAuthenticatedArticle.log', 'telegram')
            ->debug(var_export($result, true));
    }
}
