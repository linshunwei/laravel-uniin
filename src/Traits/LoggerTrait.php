<?php

namespace Linshunwei\Uniin\Traits;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

trait LoggerTrait
{
	protected function logInfo(string $message, array $context = []): void
	{
		if (!$this->isLoggerEnabled()) return;
		$this->getLogger()->info($message, $context);
	}

	protected function logError(string $message, array $context = []): void
	{
		if (!$this->isLoggerEnabled()) return;
		$this->getLogger()->error($message, $context);
	}

	protected function logRequestResponse(string $method, array $request = [], $response = null, ?float $startTime = null): void
	{
		if (!$this->isLoggerEnabled()) return;

		$elapsed = $startTime ? round((microtime(true) - $startTime) * 1000, 2) . ' ms' : null;

		$context = [
			'request'  => $request,
			'response' => $response,
		];

		if ($elapsed) {
			$context['elapsed'] = $elapsed;
		}

		$this->logInfo("Service method [{$method}] called", $context);
	}

	protected function isLoggerEnabled(): bool
	{
		return config('uniin.logger.enable', false);
	}

	protected function getLogger(): Logger
	{
		$logDir = config('uniin.logger.path', storage_path('logs')) ;
		if (!is_dir($logDir)) {
			mkdir($logDir, 0755, true);
		}

		$logPath = $logDir . '/uniin-' . date('Y-m-d') . '.log';

		$logger = new Logger('uniin');
		$logger->pushHandler(new StreamHandler($logPath, Logger::DEBUG));

		return $logger;
	}
}
