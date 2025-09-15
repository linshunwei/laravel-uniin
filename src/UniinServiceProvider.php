<?php

namespace Linshunwei\Uniin;

use Illuminate\Support\ServiceProvider;

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
