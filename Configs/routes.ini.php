<?php

use Aljerom\Solnushkov\Application\ApiResource\CreateTemporaryUserApi;
use Aljerom\Solnushkov\Application\ApiResource\CssInlinerApi;
use Aljerom\Solnushkov\Application\ApiResource\ImageOverlayApi;
use Aljerom\Solnushkov\Application\ApiResource\VerifyTemporaryUserApi;
use Aljerom\Solnushkov\Infrastructure\Controllers\Api;

return [
    'POST:cssInliner' => [
        'controller' => [Api::class, 'cssInliner'],
        'apiResource' => CssInlinerApi::class,
    ],
    'POST:createTemporaryUser' => [
        'controller' => [Api::class, 'createTemporaryUser'],
        'apiResource' => CreateTemporaryUserApi::class,
    ],
    'POST:verifyTemporaryUser' => [
        'controller' => [Api::class, 'verifyTemporaryUser'],
        'apiResource' => VerifyTemporaryUserApi::class,
    ],
    '*:imageOverlay' => [
        'controller' => [Api::class, 'ImageOverlay'],
        'apiResource' => ImageOverlayApi::class,
    ],
];
