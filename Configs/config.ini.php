<?php

return [
    'mod_config' => [
        // Доступность в списке модулей админки
        'isVisible' => true,

        // Наименование модуля
        'moduleTitle' => 'Солнушков',

        // Список автоматически создаваемых директорий модуля, доступных для записи
        // Каждый элемент массива - путь, относительно DOCUMENT_ROOT/vardata/modules/<moduleName>
        'vardata' => ['log'],

        // Директории дампируемых данных. Каждый элемент массива - путь к директории, относительно DOCUMENT_ROOT
        'dumpFiles' => ['/vardata/modules/solnushkov'],
    ],

    'tables' => [
        'emailUser' => 'sol__emailUser',
    ],

    'api' => [
        'uri' => 'mail.corp.solnushkov.ru/json.php/api',
        'key' => '100500',
        'emailWarnings' => '/emailWarning',
    ],

    'path' => __DIR__ . '/../',
];
