<?php

namespace Aljerom\Solnushkov\Application\Service;

use App\Service\Image\ImageManager;
use Aljerom\Solnushkov\Application\ApiResource\Dto\ImageOverlayParams;

class ImageOverlayCreator
{
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * @param ImageOverlayParams $params
     */
    public function handle(ImageOverlayParams $params): void
    {
        if (!file_exists(ROOT_DIR . $params->fileSource)) {
            throw new \RuntimeException('Файл исходного изображения не существует');
        }

        $image = $this->imageManager->make(ROOT_DIR . $params->fileSource);
        $interventionImage = $image->interventionImage();
        $interventionImage->rectangle(
            0,
            0,
            $interventionImage->getWidth(),
            $interventionImage->getHeight(),
            function ($draw) use ($params) {
                //$draw->background('#ff0000');
                $draw->background(
                    sprintf('rgba(%d, %d, %d, %s)', $params->layerR, $params->layerG, $params->layerB, $params->layerA)
                );
                //$draw->border(2, '#000');
            }
        );

        $x = round($interventionImage->getWidth() / 2);
        $x += round($x * $params->textOffsetX / 5);
        $y = round($interventionImage->getHeight() / 2);
        $y += round($y * $params->textOffsetY / 5);
        $interventionImage->text(
            $params->textMessage,
            $x,
            $y,
            function ($font) use ($params) {
                $font->file(ROOT_DIR . $params->textFont);
                $font->size($params->textSize);
                $font->color($params->textColor);
                //$font->color(array(255, 255, 255, 0.5));
                $font->align($params->textAlign);
                $font->valign($params->textValign);
                $font->angle($params->textRotation);
            }
        );

        $image->save(ROOT_DIR . $params->fileResult);
    }
}
