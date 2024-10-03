<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use Aljerom\Solnushkov\Application\ApiResource\Dto\ImageOverlayParams;
use MagicPro\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @method ImageOverlayParams getValidatedMessage(ServerRequestInterface $request, ValidatedMessageInterface $validatedMessage)
 */
class ImageOverlayApi extends AbstractApiResource
{
    public function getResourceDescription(): string
    {
        return <<<STR
Обработка исходной картинки
 - наложение цветного фона с параметрами прозрачности
 - наложение текстового элемента
STR;
    }

    public function inputParam(): string
    {
        return ImageOverlayParams::class;
    }

    public function outputParam(): string
    {
        return 'Строка, путь к созданной картинке';
    }
}
