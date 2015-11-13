
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
			13 => '韻達快遞',
			14 => '郵局航空包裹',
			15 => '郵局EMS快遞',
			16 => 'DHL',
			17 => '德揚國物',
			18 => '全球快遞',
			20 => '客戶自取'
		);

	protected static $type_enu = array(
			'' => '',
			0 => 'Standard Express',
			1 => 'Economy Express',
			2 => 'Land',
			10 => 'Post Office',
			11 => 'SF Express',
			12 => 'Normal Express',
			13 => '韻達快遞',
			14 => '郵局航空包裹',
			15 => '郵局EMS快遞',
			16 => 'DHL',
			17 => '德揚國物',
			18 => '全球快遞',
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
			13 => '韻達快遞',
			14 => '郵局航空包裹',
			15 => '郵局EMS快遞',
			16 => 'DHL',
			17 => '德揚國物',
			18 => '全球快遞',
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
			'Beijing' => '北京',
			'Hebei' => '河北',
			'Shanghai' => '上海',
			'Suzhou' => '蘇州',
			'Xuzhou' => '徐州',
			'Shaanxi' => '陝西',
			'Guangdong' => '廣東',
			'Shenzhen' => '深圳',
			'Guangzhou' => '廣州',
			'Hainan' => '海南',
			'Sanya' => '三亞',
			'Guangxi' => '廣西',
			'Nanning' => '南寧',
			'Yunnan' => '雲南',
			'Liaoning' => '遼寧',
			'Shandong' => '山東',
			'Qingdao' => '青島',
			'Fuzhou' => '福州',
			'Xiamen' => '廈門',
			'Sichuan' => '四川',
			'Chengdu' => '成都',
			'HongKong' => '香港/澳門',
			'Korea' => '韓國',
			'Taiwan' => '台灣',
			'Jinan' => '濟南',
			'Zhuhai' => '珠海',
			'Kunming' => '昆明',
			'Zhanjiang' => '湛江',
			'Shenyang' => '瀋陽',
			'Zibo' => '淄博',
			'Dalian' => '大連',
			'Huizhou' => '惠州',
			'Guiyang' => '貴陽',
			'Nanjing' => '南京',
			'Else' => '其他',
		);

	static public function getRegionList(){
		return self::$region;
	}

	static public function getRegion($reg){
		return self::$region[$reg];
	}

}

