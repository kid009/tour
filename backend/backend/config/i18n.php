<?php
return [
    'color' => null,
    'interactive' => true,
    'help' => null,
    'sourcePath' => __DIR__ . DIRECTORY_SEPARATOR . '..', //
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR . 'messages',//
    'languages' => ['th'],//
    'translator' => 'Yii::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        //'/BaseYii.php',
    ],
    'only' => [
        '*.php',
    ],
    'format' => 'php',
    'db' => 'db',
    'sourceMessageTable' => '{{%source_message}}',
    'messageTable' => '{{%message}}',
    'catalog' => 'messages',
    'ignoreCategories' => [],
];
