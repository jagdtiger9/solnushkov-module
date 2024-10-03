<?php

use Aljerom\Solnushkov\Application\ApiResource\CreateTemporaryUserApi;
use Aljerom\Solnushkov\Application\ApiResource\CssInlinerApi;
use Aljerom\Solnushkov\Application\ApiResource\ImageOverlayApi;
use Aljerom\Solnushkov\Application\ApiResource\VerifyTemporaryUserApi;
use Aljerom\Solnushkov\Infrastructure\Controllers\Api;

return [
    'POST:cssInliner' => new \MagicPro\Router\Routes\Resource\ApiResourceFullDescription(
        controller: [Api::class, 'cssInliner'],
        apiResource: CssInlinerApi::class,
    ),
    'POST:createTemporaryUser' => new \MagicPro\Router\Routes\Resource\ApiResourceFullDescription(
        controller: [Api::class, 'createTemporaryUser'],
        apiResource: CreateTemporaryUserApi::class,
    ),
    'POST:verifyTemporaryUser' => new \MagicPro\Router\Routes\Resource\ApiResourceFullDescription(
        controller: [Api::class, 'verifyTemporaryUser'],
        apiResource: VerifyTemporaryUserApi::class,
    ),
    '*:imageOverlay' => new \MagicPro\Router\Routes\Resource\ApiResourceFullDescription(
        controller: [Api::class, 'ImageOverlay'],
        apiResource: ImageOverlayApi::class,
    ),
];
