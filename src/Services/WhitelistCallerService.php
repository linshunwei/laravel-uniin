<?php

namespace Linshunwei\Uniin\Services;

class WhitelistCallerService  extends BaseService
{
	/**
	 * A路白名单号码报备申请接口
	 * @param $member 报备人
	 * [
	 * 'caller' => 报备人主叫号码,
	 * 'reportName' => 号码所属人姓名,
	 * 'idType' => 居民身份证 1 港澳通行证 2 护照新增操作必填，删除操作选填,
	 * 'idNumber' => 证件号码,
	 * 'scenePhoto' => 人脸照片base64 编码。照片需小于32k,jpg格式新增操作必填，删除操作选填,
	 * 'idCardFrontPhoto' => 照片base64编码照片需小于32k,jpg格式,
	 * 'idCardBackPhoto' => 照片base64编码照片需小于32k,jpg格式,
	 * ]
	 * @param $optType 0 新增成员 1 删除成员
	 * @return array|mixed
	 */
	public function report($member = [], $optType = 0)
	{
		$data = [
			'appId' => $this->config['app_id'],
			'caller' => 0, // 0 手机号 1 固定电话
			'optType' => $optType, //0 新增成员 1 删除成员
			'reportType' => 0, //0 个人 1法人 2经办人 如果号码类型为固定电话，则需要传 1 或 2
			'member' => $this->sm4_encrypt_ecb(json_encode($member)),
		];
		return $this->post('/Accounts/' . $this->config['account_sid'] . '/whitelist/caller/report', $data);
	}

	/**
	 * A路白名单号码报备结果查询接口
	 * @param array $callers 电话号码
	 * @return array|bool|string[]
	 */
	public function reportStatus($callers = []){
		$data = [
			'appId' => $this->config['app_id'],
			'callers' => $this->sm4_encrypt_ecb(json_encode($callers))
		];
		$data = $this->post('/Accounts/' . $this->config['account_sid'] . '/whitelist/caller/report/status', $data);
		if (data_get($data,'data')){
			$data['data'] =json_decode( $this->sm4_decrypt_ecb($data['data']),1);
		}
		return $data;
	}

	/**
	 * A路白名单号码报备结果查询接口
	 * @param array $callers 电话号码
	 * @return array|bool|string[]
	 */
	public function query($callers = []){
		$data = [
			'appId' => $this->config['app_id'],
			'callers' => $this->sm4_encrypt_ecb(json_encode($callers))
		];
		$data = $this->post('/Accounts/' .  $this->config['account_sid'] . '/whitelist/caller/query', $data);
		if (data_get($data,'data')){
			$data['data'] =json_decode( $this->sm4_decrypt_ecb($data['data']),1);
		}
		return $data;
	}

}
