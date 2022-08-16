<?php

namespace Aljerom\Solnushkov\Application\ApiResource;

use App\Api\AbstractApiResource;
use MagicPro\Messenger\Validation\ValidatedMessageInterface;
use Aljerom\Solnushkov\Application\ApiResource\Dto\ImageOverlayParams;
use Psr\Http\Message\ServerRequestInterface;

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

    public function getValidatedMessage(ServerRequestInterface $request, ValidatedMessageInterface $validatedMessage): ImageOverlayParams
    {
        return $validatedMessage->fromRequest($this->inputParam(), $request);
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
