
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
			$crewpak == 'P70139CL' || 
			$crewpak == 'P70139KL' || 
			$crewpak == 'P79315CSP'
		){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2.6 * $qty;
			} else {
				$fee = round((6.5 * $qty) * 100 / 21) / 100;
			}
		}
		else if(0 == strcmp('xm', $warehouse)){
			$fee = 9.1 * $qty;
		} else {
			$fee = round((39 * $qty) * 100 / 21) / 100;
		}
		return $fee;
	}

	static public function getProductServiceFee($qty, $warehouse, $product){

		if($product == '70150K' ||
			$product == '70150C' ||
			$product == '70150SC' ||
			$product == '60020C' ||
			$product == '60020SC' ||
			$product == '60020K' ||
			$product == '60038C' ||
			$product == '60038K' ||
			$product == '60134C' ||
			$product == '60134SC' ||
			$product == '60134K' ||
			$product == '60303C' ||
			$product == '60303SC' ||
			$product == '60303K' ||
			$product == '60304C' ||
			$product == '60304SC' ||
			$product == '60304K' ||
			$product == '60330C' ||
			$product == '60330SC' ||
			$product == '60330K' ||
			$product == '60346C' ||
			$product == '60346SC' ||
			$product == '60346K' ||
			$product == '61301C' ||
			$product == '61301SC' ||
			$product == '61301K' ||
			$product == '70149C' ||
			$product == '70149SC'
		){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 9.1 * $qty;
			} else {
				$fee = round((39 * $qty) * 100 / 21) / 100;
			}
		} else {
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2.6 * $qty;
			} else {
				$fee = round((6.5 * $qty) * 100 / 21) / 100;
			}
		}

		return $fee;
	}

	static public function getAssembleServiceFee($qty, $warehouse, $product){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 7 * $qty;
		} else {
			$fee = round((30 * $qty) * 100 / 21) / 100;
		}

		return $fee;
	}

	static public function getShipFreightFee($org_fee, $region, $warehouse, $type, $weight, $box){

		if(ShippingType::T_SELFPICK == $type){
			return 0;
		}

		if(0 == strcmp('xm', $warehouse)){

			if(ShippingType::T_DPN == $type){
				$fee = 1.1 * $org_fee;


				switch ($region) {

					case 'Beijing': //'北京'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.58;
						$traffic_base = 80;
						break;

					case 'Tianjin': //'天津'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.34;
						$traffic_base = 55;
						break;

					case 'Shanghai': //'上海'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 1.69;
						$traffic_base = 80;
						break;

					case 'Jiangsu': // 江蘇
					case 'Suzhou': //'蘇州'
					case 'Xuzhou': //'徐州'
					case 'Nanjing': //'南京'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.57;
						$traffic_base = 55;
						break;

					case 'Zhejiang': // 浙江
					case 'Hangzhou': //'杭州'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.07;
						$traffic_base = 55;
						break;

					case 'Shenzhen': //'深圳'
					case 'Guangzhou': //'廣州'
					case 'Zhuhai': //'珠海'
					case 'Zhanjiang': //'湛江'
					case 'Huizhou': //'惠州'
					case 'Guangdong': //'廣東'
						$kg_1 = 9;
						$kg_2 = 12;
						$kg3_first = 13.6;
						$kg3_addtional = 3.2;
						$rate = 2.06;
						$traffic_base = 55;
						break;

					case 'Fujian': // 福建
					case 'Fuzhou': //'福州'
					case 'Xiamen': //'廈門'
						$kg_1 = 8;
						$kg_2 = 10;
						$kg3_first = 10.4;
						$kg3_addtional = 0.8;
						$rate = 1;
						$traffic_base = 40;
						break;

					case 'Jiangxi': // 江西
						$kg_1 = 9;
						$kg_2 = 12;
						$kg3_first = 13.6;
						$kg3_addtional = 3.2;
						$rate = 2.36;
						$traffic_base = 55;
						break;

					case 'Hunan': //'湖南'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.54;
						$traffic_base = 55;
						break;

					case 'Hubei': //'湖北'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.55;
						$traffic_base = 55;
						break;

					case 'Sanya': //'三亞'
					case 'Wenchang ': //'海南文昌'
					case 'Wanning': //'海南萬寧',
					case 'Hainan': //'海南'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.5;
						$traffic_base = 80;
						break;

					case 'Anhui': //安徽
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.61;
						$traffic_base = 55;
						break;

					case 'Guangxi': //'廣西'
					case 'Nanning': //'南寧'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.61;
						$traffic_base = 55;
						break;

					case 'Chongqing': //'重慶'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.85;
						$traffic_base = 55;
						break;

					case 'Henan': //河南
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.87;
						$traffic_base = 55;
						break;

					case 'Shandong': //'山東'
					case 'Qingdao': //'青島'
					case 'Jinan': //'濟南'
					case 'Zibo': //'淄博'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 3.4;
						$traffic_base = 55;
						break;

					case 'Shaanxi': //'陝西'
					case 'Xian': //'西安'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 2.89;
						$traffic_base = 55;
						break;

					case 'Guizhou': // 貴州
					case 'Guiyang': //'貴陽'
						$kg_1 = 10;
						$kg_2 = 13;
						$kg3_first = 14.4;
						$kg3_addtional = 3.2;
						$rate = 3.42;
						$traffic_base = 55;
						break;

					case 'Sichuan': //'四川'
					case 'Chengdu': //'成都'
						$kg_1 = 10;
						$kg_2 = 14;
						$kg3_first = 15.2;
						$kg3_addtional = 3.2;
						$rate = 3.49;
						$traffic_base = 55;
						break;

					case 'Hebei': //'河北'
					case 'Tangshan': //'唐山'
					case 'Qinhuangdao': //'秦皇島'
						$kg_1 = 10;
						$kg_2 = 14;
						$kg3_first = 15.2;
						$kg3_addtional = 3.2;
						$rate = 5.93;
						$traffic_base = 55;
						break;

					case 'Shanxi': //山西
						$kg_1 = 10;
						$kg_2 = 14;
						$kg3_first = 15.2;
						$kg3_addtional = 3.2;
						$rate = 3.31;
						$traffic_base = 55;
						break;

					case 'Yunnan': //'雲南'
					case 'Kunming': //'昆明'
						$kg_1 = 10;
						$kg_2 = 14;
						$kg3_first = 15.2;
						$kg3_addtional = 3.2;
						$rate = 3.46;
						$traffic_base = 65;
						break;

					case 'Liaoning': //'遼寧'
					case 'Shenyang': //'瀋陽'
					case 'Dalian': //'大連'
						$kg_1 = 11;
						$kg_2 = 16;
						$kg3_first = 19.2;
						$kg3_addtional = 4.8;
						$rate = 3.69;
						$traffic_base = 55;
						break;

					// Jilin, Heilongjiang, Ningxia, Gansu

					default:
						$dp_fee = $org_fee;
						break;
				}


				if($weight <= 1){
					$dp_fee = $kg_1;
				} else if ($weight <= 2) {
					$dp_fee = $kg_2;
				} else if ($weight <= 30) {
					$dp_fee = round($kg3_first + $kg3_addtional * ($weight - 3));
				} else if ($weight <= 60) {
					$dp_fee = round(2 * $kg3_first + $kg3_addtional * ($weight - 3));
				} else {

					$traffic_fee = ($weight < 276) ? $traffic_base : max(100, $weight * 0.2);
					$upstair_fee = ($weight < 51) ? 30 : $weight;
					$dp_fee = ceil($weight * $rate) + $traffic_fee + $upstair_fee + 24;
				}

				$fee = ceil(1.1 * $dp_fee - 0.01);

			} else {

				switch ($region) {

					case 'Shandong': //'山東'
					case 'Beijing': //'北京'
					case 'Hebei': //'河北'
					case 'Henan': //河南
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

					case 'Yunnan': //'雲南'
					case 'Kunming': //'昆明'
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
						if(ShippingType::T_STD_EXPR== $type || ShippingType::T_SF_SP== $type){
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
					case 'Hubei': //'湖北'
					case 'Jiangxi': // 江西
					case 'Hunan': //'湖南'
					case 'Chengdu': //'成都'
					case 'Guizhou': // 貴州
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

					case 'Shanxi': //山西
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

					case 'Fujian': // 福建
					case 'Fuzhou': //'福州'
						if(ShippingType::T_STD_EXPR== $type || ShippingType::T_SF_SP== $type){
							$fee = ceil(1.1 * (11 + 2 * $weight));
						} else if (ShippingType::T_SF_NORMAL== $type) {
							$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
						} else {
							$fee = 1.1 * $org_fee;
						}
						break;

					case 'Xiamen': //'廈門'
						if(ShippingType::T_STD_EXPR== $type || ShippingType::T_SF_SP== $type){
							$fee = ceil(1.1 * (11 + $weight));
						} else if (ShippingType::T_SF_NORMAL== $type) {
							$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
						} else {
							$fee = 1.1 * $org_fee;
						}
						break;

					case 'Jiangsu': // 江蘇
					case 'Suzhou': //'蘇州'
					case 'Xuzhou': //'徐州'
					case 'Nanjing': //'南京'
					case 'Zhejiang': // 浙江
					case 'Hangzhou': //'杭州'
					case 'Anhui': //安徽
						if(ShippingType::T_STD_EXPR== $type){
							$fee = ceil(1.1 * (12 + 10 * $weight));
						} else if (ShippingType::T_SF_SP== $type) {
							$fee = ceil(1.1 * (12 + 6 * $weight));
						} else if (ShippingType::T_SF_NORMAL== $type) {
							$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : (3.5 * $weight))));
						} else {
							$fee = 1.1 * $org_fee;
						}
						break;

					default:
						$fee = 1.1 * $org_fee;
						break;
				}
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
					$fee = 1.1 * $org_fee / 21;
					break;
			}
		}

		return ceil($fee);
	}

}
