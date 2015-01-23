
<?php

class ShippingType
{
	const T_STD_EXPR = 0;
	const T_SF_SP = 1;
	const T_SF_NORMAL = 2;
	const T_CHI_MAIL = 10;
	const T_SF = 11;
	const T_NEW = 12;
	const T_SELFPICK = 20;


	protected static $transfer_type = array(
			'sea' => '海運',
			'air' => '空運',
			'dhl' => 'DHL',
			'sf' => '順豐快遞',
			'blair' => '寶聯空運',
			'blsea' => '寶聯海運',
			'internal' => '內部轉移',
		);

	protected static $type = array(
			'' => '',
			0 => '標準快遞',
			1 => '順丰特惠',
			2 => '物流普運',
			10 => '中華郵政',
			11 => '順丰快遞',
			12 => '新航快遞',
			20 => '客戶自取'
		);

	protected static $type_enu = array(
			'' => '',
			0 => '標準快遞',
			1 => '順丰特惠',
			2 => '物流普運',
			10 => 'Post Office',
			11 => 'SF Express',
			12 => 'Normal Express',
			20 => 'Pick up'
		);

	public function getType(){
		return self::$type;
	}

	public function getTransferType(){
		return self::$transfer_type;
	}

	public function getXMType(){
		return  array(
			'' => '',
			0 => '標準快遞',
			1 => '順丰特惠',
			2 => '物流普運',
			20 => '客戶自取'
		);
	}


	public function getTWType(){
		return  array(
			'' => '',
			10 => '中華郵政',
			11 => '順丰快遞',
			12 => '新航快遞',
			20 => '客戶自取'
		);
	}

	static public function getShippingType($t, $lang='cht'){
		if($lang == 'cht'){
			return self::$type[$t];
		} else {
			return self::$type_enu[$t];
		}
	}

	static public function getTransferShippingType($t){
		return self::$transfer_type[$t];
	}

}


class ShippingRegion
{

	protected static $region = array(
			'' => '',
			'Hebei' => '北京 天津 (河北)',
			'Shanghai' => '上海 江蘇 浙江',
			'Shaanxi' => '西安 (陝西)',
			'Guangdong' => '深圳 廣州 (廣東)',
			'Hainan' => '三亞 (海南)',
			'Guangxi' => '南寧 (廣西)',
			'Yunnan' => '昆明 (雲南)',
			'Liaoning' => '大連 (遼寧)',
			'Shandong' => '青島 (山東)',
			'Fuzhou' => '福州 (福建)',
			'Xiamen' => '廈門 (福建)',
			'Sichuan' => '四川',
			'HongKong' => '香港',
			'Korea' => '韓國',
			'Taiwan' => '台灣',
			'Else' => '其他',
		);

	static public function getRegionList(){
		return self::$region;
	}

	static public function getRegion($reg){
		return self::$region[$reg];
	}

}

