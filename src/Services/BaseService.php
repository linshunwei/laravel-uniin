<?php

namespace Linshunwei\Uniin\Services;

use GuzzleHttp\Client;
use Linshunwei\Uniin\Traits\LoggerTrait;

abstract class BaseService
{
	use LoggerTrait;

	protected Client $client;
	protected array $config;

	public function __construct()
	{
		$this->config = config('uniin');
		$time = date('YmdHis');
		$this->client = new Client([
			'base_uri' => $this->config['host'],
			'timeout' => 10,
			'headers' => [
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
				'Authorization' => base64_encode($this->config['account_sid'] . ':' . $time),
				'sig' => strtoupper(md5($this->config['account_sid'] . $this->config['auth_token'] . $time)),
			],
		]);
	}

	protected function get(string $uri, array $query = [])
	{
		$response = $this->client->get($uri, ['query' => $query]);
		return json_decode($response->getBody()->getContents(), true);
	}

	protected function post(string $uri, array $data = [], $decrypt_data = false)
	{
		$start = microtime(true);

		$response = $this->client->post($uri, ['json' => $data]);
		$body = json_decode($response->getBody()->getContents(), true);

		if ($decrypt_data && data_get($body, 'data')) {
			//todo 解码data
			$body['data'] = json_decode($this->sm4_decrypt_ecb($body['data']), 1);
		}
		// 记录日志
		$this->logRequestResponse("POST {$uri}", $data, $body, $start);

		return $body;
	}

	public function sm4_encrypt_ecb(string $plaintext): string
	{
		$cipher = 'SM4-ECB';
		$key = substr($this->config['auth_token'], 0, 16);
		// OPENSSL_ZERO_PADDING 表示不要自动填充，按 PKCS#7 自己补
		$padded = $this->pkcs7_pad($plaintext, 16);
		$ciphertext = openssl_encrypt($padded, $cipher, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
		return base64_encode($ciphertext);
	}

	public function sm4_decrypt_ecb(string $ciphertext_b64): string
	{
		$cipher = 'SM4-ECB';
		$key = substr($this->config['auth_token'], 0, 16);
		$ciphertext = base64_decode($ciphertext_b64);
		$plaintext_padded = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
		return $this->pkcs7_unpad($plaintext_padded);
	}

// 辅助函数：PKCS#7 填充与去除
	protected function pkcs7_pad(string $data, int $blockSize): string
	{
		$pad = $blockSize - (strlen($data) % $blockSize);
		return $data . str_repeat(chr($pad), $pad);
	}

	protected function pkcs7_unpad(string $data): string
	{
		$pad = ord(substr($data, -1));
		return substr($data, 0, -$pad);
	}

}
