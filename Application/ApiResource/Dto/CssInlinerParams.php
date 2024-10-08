<?php

namespace Aljerom\Solnushkov\Application\ApiResource\Dto;

use MagicPro\Messenger\Validation\MessageValidatedInterface;
use MagicPro\Messenger\Validation\MessageValidatedTrait;
use MagicPro\DDD\SimpleDto\SimpleDto;

class CssInlinerParams extends SimpleDto implements MessageValidatedInterface
{
    use MessageValidatedTrait;

    /**
     * Html текст со стилями
     * @var string
     */
    public string $htmlCssText;

    /**
     * Преобразование блока &lt;styles&gt; в style-атрибуты тегов
     * @var int
     */
    public int $disableStyleBlocksParsing = 0;

    /**
     * Добавление некоторых стилей как html аттрибутов к элементу
     * Поддержка email клиентов, не отрабатывающих CSS стили корректно
     * @var int
     */
    public int $convertCssToVisualAttributes = 0;

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'htmlCssText' => 'required|string',
            'disableStyleBlocksParsing' => 'in:0,1',
            'convertCssToVisualAttributes' => 'in:0,1',
        ];
    }
}
