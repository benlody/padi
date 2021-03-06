
<?php

class ShippingType
{
	const T_STD_EXPR = 0;
	const T_SF_SP = 1;
	const T_SF_NORMAL = 2;
	const T_DPN = 3;
	const T_CHI_MAIL = 10;
	const T_SF = 11;
	const T_NEW = 12;
	const T_SELFPICK = 20;
	const T_BLACKCAT = 25;


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
			0 => '順丰次日',
			1 => '順丰隔日',
			2 => '順丰物流普運',
			3 => '德邦物流',
			10 => '中華郵政',
			11 => '順丰快遞',
			12 => '新航快遞',
			13 => '韻達快遞',
			14 => '郵局航空包裹',
			15 => '郵局EMS快遞',
			16 => 'DHL',
			17 => '德揚國物',
			18 => '全球快遞',
			19 => '司機送貨',
			20 => '客戶自取 (現不開放自取 請勿使用)',
			21 => '兆太國際物流',
			22 => '順豐快遞貨到付款',
			23 => '黑貓到付',
			24 => '海運空運出口',
			25 => '黑貓宅急便'

		);

	protected static $type_enu = array(
			'' => '',
			0 => 'SF Next Day',
			1 => 'SF Third Day',
			2 => 'SF Land',
			3 => 'Deppon',
			10 => 'Post Office',
			11 => 'SF Express',
			12 => 'Hiyes Express',
			13 => 'Yunda Express',
			14 => 'Post Office Air',
			15 => 'EMS',
			16 => 'DHL',
			17 => 'Deyang LOGISTICS',
			18 => 'GB Express',
			19 => 'By Trunk',
			20 => 'Pick up (Now not allow, dont use it)',
			21 => 'JSD LOGISTICS',
			22 => 'SF Express (COD)',
			23 => 'Black Cat (COD)',
			24 => 'SEA/AIR Export',
			25 => 'President Transnet(Black Cat)'
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
			0 => '順丰次日',
			1 => '順丰隔日',
			2 => '順丰物流普運',
			3 => '德邦物流',
			20 => '客戶自取 (現不開放自取 請勿使用)',
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
			19 => '司機送貨',
			20 => '客戶自取 (現不開放自取 請勿使用)',
			21 => '兆太國際物流',
			22 => '順豐快遞貨到付款',
			23 => '黑貓到付',
			24 => '海運空運出口',
			25 => '黑貓宅急便'
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
			'Hunan' => '湖南',
			'Chengdu' => '成都',
			'HongKong' => '香港',
			'Macau' => '澳門',
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
			'Xian' => '西安',
			'Tianjin' => '天津',
			'Qinhuangdao' => '秦皇島',
			'Tangshan' => '唐山',
			'Wenchang ' => '海南文昌',
			'Hangzhou' => '杭州',
			'Chongqing' => '重慶',
			'Wanning' => '海南萬寧',
			'Jiangsu' => '江蘇',
			'Zhejiang' => '浙江',
			'Fujian' => '福建',
			'Jiangxi' => '江西',
			'Hubei' => '湖北',
			'Anhui' => '安徽',
			'Henan' => '河南',
			'Guizhou' => '貴州',
			'Shanxi' => '山西',
			'Philippines' => '菲律賓',
			'Malaysia' => '馬來西亞',
			'GreenIsland' => '綠島',
			'Liuqiu_Henchun' => '琉球_恆春',
			'Else' => '其他',
		);

	static public function getRegionList(){
		return self::$region;
	}

	static public function getRegion($reg){
		return self::$region[$reg];
	}

}

