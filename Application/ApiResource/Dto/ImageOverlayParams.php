<?php

namespace Aljerom\Solnushkov\Application\ApiResource\Dto;

use MagicPro\DDD\SimpleDto\SimpleDto;
use MagicPro\Messenger\Validation\MessageValidatedInterface;
use MagicPro\Messenger\Validation\MessageValidatedTrait;

class ImageOverlayParams extends SimpleDto implements MessageValidatedInterface
{
    use MessageValidatedTrait;

    /**
     * Файл исходного изображения
     * @var string
     */
    public $fileSource;

    /**
     * Файл для записи полученного изображения
     * @var string
     */
    public $fileResult;

    /**
     * Rgb оверлей слоя
     * @var int
     */
    public $layerR = 0;

    /**
     * rGb оверлей слоя
     * @var int
     */
    public $layerG = 0;

    /**
     * rgB оверлей слоя
     * @var int
     */
    public $layerB = 0;

    /**
     * Прозрачность
     * @var float
     */
    public $layerA = 0;

    /**
     * Шрифт, путь к файлу шрифта
     * @var string
     */
    public $textFont = '';

    /**
     * Размер, в пикселах
     * @var int
     */
    public $textSize = 12;

    /**
     * Цвет, RGB строка
     * @var string
     */
    public $textColor = '000';

    /**
     * Смещение по X относительно центра: -5,..,0,..,+5
     * @var int
     */
    public $textOffsetX = 0;

    /**
     * Смещение по Y относительно центра: -5,..,0,..,+5
     * Например:
     *  -5 и textValign=top, текст размещается наверху картинки
     *  5 и textValign=bottom, текст размещается внизу картинки
     *  0 и textValign=middle, текст по центру
     * @var int
     */
    public $textOffsetY = 0;

    /**
     * Выравнивание: left|center|right
     * @var string
     */
    public $textAlign = 'center';

    /**
     * Выравнивание: top|middle|bottom
     * @var string
     */
    public $textValign = 'middle';

    /**
     * Угол поворота текста, любое целое число
     * @var int
     */
    public $textRotation = 0;

    /**
     * Надпись
     * @var string
     */
    public $textMessage = '';

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'fileSource' => 'required|string',
            'layerG' => 'integer',
            'layerB' => 'integer',
            'layerA' => 'numeric',
            'layerR' => 'integer',
            'textFont' => 'string',
            'textSize' => 'integer',
            'textColor' => 'string',
            'textOffsetX' => 'in:-5,-4,-3,-2,-1,0,1,2,3,4,5',
            'textOffsetY' => 'in:-5,-4,-3,-2,-1,0,1,2,3,4,5',
            'textAlign' => 'in:left,center,right',
            'textValign' => 'in:top,middle,bottom',
            'textRotation' => 'integer',
            'textMessage' => 'string',
        ];
    }
}
