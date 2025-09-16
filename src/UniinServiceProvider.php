<?php

namespace Linshunwei\Uniin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class UniinServiceProvider extends ServiceProvider
{
	public function register()
	{
		// 合并配置
		$configPath = __DIR__.'/../config/uniin.php';
		$this->mergeConfigFrom(
			$configPath,
			'uniin'
		);

		Log::extend('uniin', function ($app, array $config) {
			return new Logger('uniin', [
				new RotatingFileHandler(
					storage_path('logs/uniin.log'),
					7, // 保留 7 天
					Logger::DEBUG
				),
			]);
		});



		$this->app->singleton('uniin', function () {
			return new Uniin();
		});
	}

	public function boot()
	{
		// 发布配置文件
		$configPath = __DIR__.'/../config/uniin.php';
		$this->publishes([
			$configPath => config_path('uniin.php'),
		], 'config');
	}
}
