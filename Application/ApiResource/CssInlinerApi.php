<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use Aljerom\Solnushkov\Application\ApiResource\Dto\CssInlinerParams;
use MagicPro\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @method CssInlinerParams getValidatedMessage(ServerRequestInterface $request, ValidatedMessageInterface $validatedMessage)
 */
class CssInlinerApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Html + css style inliner
https://github.com/MyIntervals/emogrifier
STR;
    }

    public function inputParam(): string
    {
        return CssInlinerParams::class;
    }

    public function outputParam(): string
    {
        return 'Строка, форматированный текст';
    }
}
