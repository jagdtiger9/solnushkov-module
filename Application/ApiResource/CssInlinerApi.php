<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use App\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Aljerom\Solnushkov\Application\ApiResource\Dto\CssInlinerParams;
use Psr\Http\Message\ServerRequestInterface;

class CssInlinerApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Html + css style inliner
https://github.com/MyIntervals/emogrifier
STR;
    }

    public function getValidatedMessage(ServerRequestInterface $request, ValidatedMessageInterface $validatedMessage): CssInlinerParams
    {
        return $validatedMessage->fromRequest($this->inputParam(), $request);
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
