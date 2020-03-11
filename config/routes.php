<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'prefix' => '/api',
        'controller' => 'v1/user',
        'tokens' => [
            '{id}' => '<id:\\w+>'
        ],
        'extraPatterns' => [
            'POST login' => 'login'
        ]
    ]
];