<?php

namespace Linshunwei\Uniin\Services;

/**
 * axb 模式
 */
class AxbService extends BaseService
{
	/**
	 * @param array $data
	 * aNumber String 用户A的电话号码 必选
	 * xNumber String 可选X号码，如果此字段未提供，则平台会自动分配一个X号码返回
	 * bNumber String 用户A固定回呼的电话号码 可选
	 * expectAreaCode String 可选当需要平台自动分配X号码时，可以通过此字段指定区号城市的X号码。如未指定区号，则系统将根据一定策略进行随机分配X号码，X号码分配顺序为areacode指定地区>B归属地市>B省会>全国随机
	 * expectStrict Stringe 可选进行X号码分配时，是否严格按照expectAreaCode字段指定的区域分配。如果在指定区域未分配到，那么将返回失败。0：否；1：是。默认为0
	 * mappingDuration String 可选绑定的指定有效时长，单位是秒，到时后会映射关系自动释放。0表示不指定绑定时长，则平台将保留绑定关系4 个月。默认值为7200
	 * anucode String 可选 主叫个性化放音控制字段 格式为逗号分隔的放音编码，包含三个场景如：“1,2,3” ， 放音编码为放音文件名称(不带后缀)，每个编码的含义如下：
	 *   1：A 呼叫X 号码时，转接过程中给 A 播放的语音文件编码
	 *   2：任意其他号码 N 呼叫 X 号码时，转接过程中给主叫播放的语音文件编码
	 *   3：其他号码呼叫 X 号码或绑定关系失效时，转接过程中给
	 *   主叫播放的语音文件编码
	 *   默认 "0,0,0" ，0 表示不放音。
	 *   特别说明：如果需要平台放音，语音文件需要通过平台rest 接口或者门户网站进行语音文件上传，文件审核通过后方可使用。
	 * recordMode String 可选 录音方式。0：被叫接听后开始录音；1：外呼/拨通时开始录音。默认为 0
	 * callNotifyUrl String 可选 呼叫状态通知回调 URL
	 * cdrNotifyUrl String 可选 话单通知回调 URL
	 * recordNotifyUrl String 可选 录音通知回调 URL
	 * smsNotifuUrl Stirng 可选 短信通知回调 URL（目前暂时不支持）
	 *   如需要短信转发功能，需要特别说明由后台配置，平台默认短信不转发。
	 * userData String 可选 用户自定义数据，最大长度不能超过 1024 字
	 * {“aNumber”:“13811680001”,“xNumber”:“13100200001”,“autoaxbBind”:“1”,“autoBandingDura tion”:“60”}
	 * @return mixed
	 */
	public function stdSet(array $data=[])
	{
		$data['appId'] =  $this->config['app_id'];
		return $this->post('/Accounts/' . $this->config['account_sid'] . '/axb/std/set', $data);
	}



	/**
	 * AXN 解绑
	 * @param $mappingId string 绑定ID
	 * @return mixed
	 */
	public function stdRelease(string $mappingId = ''): mixed
	{
		$data = [
			'appId' => $this->config['app_id'],
			'mappingId' => $mappingId
		];
		return $this->post('/Accounts/' . $this->config['account_sid'] . '/axb/std/release', $data);
	}

	/**
	 * 绑定更新
	 * @param string $mappingId
	 * @param string $aNumber 要更新的 A 号码
	 * @param string $bNumber 要更新的 B 号码
	 * @param int|null $mappingDuration 绑定的指定有效时长，单位是秒，到时后会映射关系自动释放。0表示不指定绑定时长，则平台将保留绑定关系4 个月。默认值为7200
	 * @return mixed
	 */
	public function stdUpdate(string $mappingId, string $aNumber = '',string $bNumber = '', int $mappingDuration = null)
	{
		$data = [
			'appId' => $this->config['app_id'],
			'mappingId' => $mappingId,
		];
		if ($bNumber) $data['bNumber'] = $bNumber;
		if ($aNumber) $data['bNumber'] = $aNumber;
		if (!is_null($mappingDuration)) $data['mappingDuration'] = $mappingDuration;
		return $this->post('/Accounts/' . $this->config['account_sid'] . '/axb/std/set', $data);
	}

	/**
	 * 查询
	 * @param $mappingId string 绑定ID
	 * @return mixed
	 */
	public function query(string $mappingId = ''): mixed
	{
		$data = [
			'appId' => $this->config['app_id'],
			'mappingId' => $mappingId
		];
		return $this->post('/Accounts/' . $this->config['account_sid'] . '/axb/std/query', $data);
	}

}
