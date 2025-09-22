<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Uniin 配置
	|--------------------------------------------------------------------------
	|
	| 这里是基础配置，比如 API 的 app_id、account_sid、auth_token 和 host。
	| 你可以在 .env 文件里配置，然后这里读取。
	| openssl 是否用openssl扩展
	|
	*/
	'app_id' => env('UNIIN_APP_ID', ''),

	'account_sid' => env('UNIIN_ACCOUNT_SID', ''),

	'auth_token' => env('UNIIN_AUTH_TOKEN', ''),

	'host' => env('UNIIN_HOST', 'https://api.example.com'),

	'openssl' => [
		'enable' => false,
	],

	'logger'=>[
		'enable' => false,
		'path' => storage_path('logs/uniin'),
	],

];
