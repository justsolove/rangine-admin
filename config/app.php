<?php
return [
	'setting' => [
		'env' => ienv('SETTING_DEVELOPMENT', DEVELOPMENT),
		'error_reporting' => ienv('SETTING_ERROR_REPORTING', E_ALL),
		'basedir' => [
			BASE_PATH, //在测试用例中需要，正式项目中删除
			BASE_PATH . '/tests',
		],
		'lang' => 'zh-CN',
		'server' => ienv('SETTING_SERVERS', 'http'),
	],
    'session' => [
        // session name,如果未设置,默认通过php.ini中获取
        'name' => 'PHPSESSION',
        //session handler 保存数据时的前缀, 如果未设置,默认通过session_name获取
        'prefix' => 'ox',
        //session 过期时间, 如果未设置, 默认通过php.ini中获取
        'expires' => 86400
    ],
	'cache' => [
		'default' => [
			'driver' => ienv('CACHE_DEFAULT_DRIVER', 'redis'),
			'host' => ienv('CACHE_DEFAULT_HOST', '127.0.0.1'),
			'port' => ienv('CACHE_DEFAULT_PORT', '6379'),
			'password' => ienv('CACHE_DEFAULT_PASSWORD', ''),
			'timeout' => ienv('CACHE_DEFAULT_TIMEOUT', '30'),
			'database' => ienv('CACHE_DEFAULT_DATABASE', '0')
		]
	],
	'database' => [
		'default' => [
			'driver' => 'mysql',
			'database' => ienv('DATABASE_DEFAULT_DATABASE', ''),
			'host' => ienv('DATABASE_DEFAULT_HOST', '127.0.0.1'),
			'username' => ienv('DATABASE_DEFAULT_USERNAME', ''),
			'password' => ienv('DATABASE_DEFAULT_PASSWORD', ''),
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => 'ims_',
			'port' => '3306',
			'strict' => false,
		]
	],
	'pool' => [
		'database' => [
			'default' => [
				'enable' => ienv('POOL_DATABASE_DEFAULT_ENABLE', false),
				'max' => ienv('POOL_DATABASE_DEFAULT_MAX', 20)
			]
		],
		'cache' => [
			'redis' => [
				'enable' => ienv('POOL_CACHE_DEFAULT_ENABLE', false),
				'max' => ienv('POOL_CACHE_DEFAULT_MAX', 20)
			]
		]
	]
];
