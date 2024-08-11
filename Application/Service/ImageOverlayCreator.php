<?php

namespace Aljerom\Solnushkov\Application\Service;

use Aljerom\Solnushkov\Application\ApiResource\Dto\ImageOverlayParams;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Intervention\Image\Typography\FontFactory;

class ImageOverlayCreator
{
    public function __construct(
        private ImageManagerInterface $imageManager
    ) {
    }

    /**
     * @param ImageOverlayParams $params
     */
    public function handle(ImageOverlayParams $params): void
    {
        if (!file_exists(ROOT_DIR . $params->fileSource)) {
            throw new \RuntimeException('Файл исходного изображения не существует');
        }

        $interventionImage = $this->imageManager->read(ROOT_DIR . $params->fileSource);
        $interventionImage->drawRectangle(
            $interventionImage->width(),
            $interventionImage->height(),
            function ($draw) use ($params) {
                //$draw->background('#ff0000');
                $draw->background(
                    sprintf('rgba(%d, %d, %d, %s)', $params->layerR, $params->layerG, $params->layerB, $params->layerA)
                );
                //$draw->border(2, '#000');
            }
        );

        $x = round($interventionImage->width() / 2);
        $x += round($x * $params->textOffsetX / 5);
        $y = round($interventionImage->height() / 2);
        $y += round($y * $params->textOffsetY / 5);
        $interventionImage->text(
            $params->textMessage,
            $x,
            $y,
            function (FontFactory $font) use ($params) {
                $font->filename(ROOT_DIR . $params->textFont);
                $font->size($params->textSize);
                $font->color($params->textColor);
                //$font->color(array(255, 255, 255, 0.5));
                $font->align($params->textAlign);
                $font->valign($params->textValign);
                $font->angle($params->textRotation);
            }
        );

        $interventionImage->save(ROOT_DIR . $params->fileResult);
    }
}
