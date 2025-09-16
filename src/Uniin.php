<?php

namespace Linshunwei\Uniin;

use Exception;


/**
 * @property \Linshunwei\Uniin\Services\WhitelistCallerService $whitelistCaller
 * @property \Linshunwei\Uniin\Services\AxbService $axb
 * @property \Linshunwei\Uniin\Services\AxybService $axyb
 * @property \Linshunwei\Uniin\Services\AxnService $axn
 * @property \Linshunwei\Uniin\Services\AxnExtService $axnExt
 *
 */

class Uniin
{
	protected $services = [];

	public function __get(string $name)
	{
		if (isset($this->services[$name])) {
			return $this->services[$name];
		}

		$class = __NAMESPACE__ . "\\Services\\" . ucfirst($name) . "Service";

		if (class_exists($class)) {
			return $this->services[$name] = new $class();
		}

		throw new Exception("Undefined service: {$name}");
	}

	public function getConfig(string $key = null, $default = null)
	{
		$config = config('uniin');

		if ($key === null) {
			return $config;
		}

		return isset($config[$key]) ? $config[$key] : $default;
	}

	public function __call($name, $arguments)
	{
		return $this->__get($name);
	}
}
