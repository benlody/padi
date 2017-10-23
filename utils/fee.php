
<?php

require_once __DIR__  . '/enum.php';

class Fee
{

	static public function getCrewpackServiceFee($qty, $warehouse, $crewpak){

		if($crewpak == '70092KL' || 
			$crewpak == 'P60032KSP' || 
			$crewpak == 'P70014CL' || 
			$crewpak == 'P70014KL' || 
			$crewpak == 'P70092CL' || 
			$crewpak == '70092CL' || 
			$crewpak == 'P70092KL' || 
			$crewpak == 'P70080KL' || 
			$crewpak == 'P70179CSP' || 
			$crewpak == 'P71142CL' || 
			$crewpak == 'P71142KL' || 
			$crewpak == 'P71142KXL' || 
			$crewpak == 'P79300CSP' || 
			$crewpak == 'P79300KSP' || 
			$crewpak == 'P70491CSP' || 
			$crewpak == 'P70491KSP' || 
			$crewpak == '79300CSP' || 
			$crewpak == '79300KSP' || 
			$crewpak == 'P79315KSP' || 
			$crewpak == '79315CSP' || 
			$crewpak == '79315KSP' || 
			$crewpak == 'P79168CSP' || 
			$crewpak == 'P79315CSP'


		){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2 * $qty;
			} else {
				$fee = round((5 * $qty) * 100 / 22) / 100;
			}
		}
		else if(0 == strcmp('xm', $warehouse)){
			$fee = 7 * $qty;
		} else {
			$fee = round((30 * $qty) * 100 / 22) / 100;
		}
		return $fee;
	}

	static public function getProductServiceFee($qty, $warehouse, $product){

		if($product == '70150K'){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 7 * $qty;
			} else {
				$fee = round((30 * $qty) * 100 / 22) / 100;
			}
		} else {
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2 * $qty;
			} else {
				$fee = round((5 * $qty) * 100 / 22) / 100;
			}
		}

		return $fee;
	}

	static public function getAssembleServiceFee($qty, $warehouse, $product){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 7 * $qty;
		} else {
			$fee = round((30 * $qty) * 100 / 22) / 100;
		}

		return $fee;
	}

	static public function getShipFreightFee($org_fee, $region, $warehouse, $type, $weight, $box){

		if(ShippingType::T_SELFPICK == $type){
			return 0;
		}

		if(0 == strcmp('xm', $warehouse)){
//			$fee = 1.1 * $org_fee;

			switch ($region) {

				case 'Shandong': //'山東'
				case 'Beijing': //'北京'
				case 'Hebei': //'河北'
				case 'Yunnan': //'雲南'
				case 'Kunming': //'昆明'
				case 'Qingdao': //'青島'
				case 'Jinan': //'濟南'
				case 'Zibo': //'淄博'
				case 'Tianjin': //'天津'
				case 'Qinhuangdao': //'秦皇島'
				case 'Tangshan': //'唐山'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (12 + 10 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : (4.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;
				
				case 'Shanghai': //'上海'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (12 + 10 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : (3.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Guangdong': //'廣東'
				case 'Shenzhen': //'深圳'
				case 'Guangzhou': //'廣州'
				case 'Zhuhai': //'珠海'
				case 'Zhanjiang': //'湛江'
				case 'Huizhou': //'惠州'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (12 + 8 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : (3.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Hainan': //'海南'
				case 'Sanya': //'三亞'
				case 'Guangxi': //'廣西'
				case 'Nanning': //'南寧'
				case 'Wenchang ': //'海南文昌'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (13 + 10 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : (3.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;
				
				case 'Liaoning': //'遼寧'
				case 'Shenyang': //'瀋陽'
				case 'Dalian': //'大連'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (10 + 13 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (12 + 6 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : (4.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Sichuan': //'四川'
				case 'Chengdu': //'成都'
				case 'Guiyang': //'貴陽'
				case 'Chongqing': //'重慶'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (10 + 13 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (12 + 6 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 34) ? (150) : (($weight <= 50) ? (4.5 * $weight) : (4 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Shaanxi': //'陝西'
				case 'Xian': //'西安'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (10 + 13 * $weight));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (12 + 6 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : (4.5 * $weight))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Fuzhou': //'福州'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (11 + 2 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Xiamen': //'廈門'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (11 + $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Suzhou': //'蘇州'
				case 'Xuzhou': //'徐州'
				case 'Nanjing': //'南京'
				case 'Hangzhou': //'杭州'
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (12 + 10 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (12 + 6 * $weight));
					} else {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : (3.5 * $weight))));
					}
					break;

				default:
					$fee = 1.1 * $org_fee;
					break;
			}

		} else {
			switch ($region) {
				case 'Taiwan': 
					$fee = ceil($weight / 18) * 11;
				break;
				case 'Korea': 

					$fee = ceil((floor($weight/20)*1780 + ($weight%20)*80 + 180)*1.1/21 - 0.0001);
				break;
				default:
					$fee = 1.1 * $org_fee / 22;
					break;
			}
		}

		return ceil($fee);
	}

}
