<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'modules' => [
		'video' => [
			'class' => 'console\modules\video\Module'
		]
	],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
		  'queue' => 'backend\component\redisqueue\QueueController'
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'queue' => [
            'class' => 'backend\component\RedisQueue',
        ],
		'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
	        'port' => 6379,
	        'database' => 0,
	        'password'  =>'foobared'
        ],
    ],
    'params' => $params,
];
