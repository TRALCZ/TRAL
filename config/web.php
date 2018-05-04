<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'layout'=>'column2',
    'layoutPath'=>'@app/themes/adminLTE/layouts',
	'language' => 'cs-CS',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'rtyrty64jgyFFWF54799',
			'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
		'dbms' => require(__DIR__ . '/dbms.php'),
		'dbde' => require(__DIR__ . '/dbde.php'),
		
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */

		'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ''=>'site/index',
                '<action:(index|login|logout)>'=>'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w\-]+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ],
        ],

		'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/adminLTE'],
                'baseUrl' => '@web/../themes/adminLTE',
            ],
        ],
		
		
		
		// setup Krajee Pdf component
		/*
		'pdf' => [
			'class' => Pdf::classname(),
			'format' => Pdf::FORMAT_A4,
			'orientation' => Pdf::ORIENT_PORTRAIT,
			'destination' => Pdf::DEST_DOWNLOAD,
			'mode' => Pdf::MODE_UTF8,
			// refer settings section for all configuration options
		],
		*/
		
				'response' => [
					'formatters' => [
						'pdf' => [
							'class' => 'robregonm\pdf\PdfResponseFormatter',
							'mode' => '', // Optional
							'format' => 'A4',  // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
							'defaultFontSize' => 0, // Optional
							'defaultFont' => '', // Optional
							'marginLeft' => 15, // Optional
							'marginRight' => 15, // Optional
							'marginTop' => 16, // Optional
							'marginBottom' => 16, // Optional
							'marginHeader' => 9, // Optional
							'marginFooter' => 9, // Optional
							'orientation' => 'Landscape', // optional. This value will be ignored if format is a string value.
							'options' => [
								// mPDF Variables
								// 'fontdata' => [
									// ... some fonts. http://mpdf1.com/manual/index.php?tid=454
								// ]
							]
						],
					]
				],
		
	    'assetManager' => [
			'bundles' => [
				'dosamigos\google\maps\MapAsset' => [
					'options' => [
						'key' => 'AIzaSyCp6eSjzd7wY8qNPNhXAMoeQunDM4j2qos',
						'language' => 'cs',
						'version' => '3.1.18'
					]
				]
			]
		],	
		
		
    ],
	
	'as beforeRequest' => [  //if guest user access site so, redirect to login page.
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'actions' => ['login'],
				'allow' => true,
			],
			[
				'allow' => true,
				'roles' => ['@'],
			],
		],
	],
		
    'params' => $params,
	
	'modules' => [
       'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
		
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
			// enter optional module parameters below - only if you need to  
			// use your own export download action or custom translation 
			// message source
			// 'downloadAction' => 'gridview/export/download',
			// 'i18n' => []
		]
    ],
	
	
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
		'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
	/*
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
		'allowedIPs' => ['*']
    ];
	*/
	$config['modules']['gii'] = [
            'class' => 'yii\gii\Module',
			'allowedIPs' => ['*'],
            'generators' => [ //here
                'crud' => [ // generator name
                    'class' => 'yii\gii\generators\crud\Generator', // generator class
                    'templates' => [ //setting for out templates
                        'custom' => '@vendor/bmsrox/yii-adminlte-crud-template', // template name => path to template
                    ]
                ]
            ],
        ];
	
	
}

return $config;
