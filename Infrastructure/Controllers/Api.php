<?php

namespace Aljerom\Solnushkov\Infrastructure\Controllers;

use Aljerom\Solnushkov\Application\ApiResource\CreateTemporaryUserApi;
use Aljerom\Solnushkov\Application\ApiResource\CssInlinerApi;
use Aljerom\Solnushkov\Application\ApiResource\ImageOverlayApi;
use Aljerom\Solnushkov\Application\ApiResource\VerifyTemporaryUserApi;
use Aljerom\Solnushkov\Application\Service\ImageOverlayCreator;
use Exception;
use MagicPro\Application\Controller;
use MagicPro\Http\Api\ErrorResponse;
use MagicPro\Http\Api\SuccessResponse;
use Pelago\Emogrifier\CssInliner;
use Pelago\Emogrifier\HtmlProcessor\CssToAttributeConverter;
use Pelago\Emogrifier\HtmlProcessor\HtmlPruner;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Api extends Controller
{
    public function cssInliner(ServerRequestInterface $request, CssInlinerApi $api): ResponseInterface
    {
        try {
            $message = $api->getValidatedMessage($request);
            $cssInliner = CssInliner::fromHtml($message->htmlCssText)->inlineCss();
            if ($message->disableStyleBlocksParsing) {
                $cssInliner = $cssInliner->disableStyleBlocksParsing();
            }
            $domDocument = $cssInliner->getDomDocument();
            HtmlPruner::fromDomDocument($domDocument)
                ->removeElementsWithDisplayNone()
                ->removeRedundantClassesAfterCssInlined($cssInliner);
            if ($message->convertCssToVisualAttributes) {
                CssToAttributeConverter::fromDomDocument($domDocument)
                    ->convertCssToVisualAttributes();
            }
            $content = $cssInliner->renderBodyContent();

            $apiResponse = new SuccessResponse($content);
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }
        return $this->setApiResponse($request, $apiResponse);
    }

    public function actionCreateTemporaryUser(
        ServerRequestInterface $request,
        CreateTemporaryUserApi $api
    ): ResponseInterface {
        try {
            $message = $api->getValidatedMessage($request);
            $this->dispatch($message);
            $apiResponse = new SuccessResponse('Данные пользователя успешно сохранены');
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect());
    }

    public function actionVerifyTemporaryUser(
        ServerRequestInterface $request,
        VerifyTemporaryUserApi $api
    ): ResponseInterface {
        try {
            $message = $api->getValidatedMessage($request);
            $this->dispatch($message);
            $apiResponse = new SuccessResponse('');
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect());
    }

    public function actionImageOverlay(
        ServerRequestInterface $request,
        ImageOverlayApi $api,
        ImageOverlayCreator $creator
    ): ResponseInterface {
        try {
            $message = $api->getValidatedMessage($request);
            $creator->handle($message);
            $apiResponse = new SuccessResponse($message->fileResult);
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect());
    }
}
