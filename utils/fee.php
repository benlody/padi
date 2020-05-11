
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
			$crewpak == 'P70080CL' || 
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
			$crewpak == 'P70139SCL' || 
			$crewpak == 'P70139KL' || 
			$crewpak == 'P79315CSP'
		){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2.6 * $qty;
			} else {
				$fee = round((6.5 * $qty) * 100 / 18.5) / 100;
			}
		}
		else if(0 == strcmp('xm', $warehouse)){
			$fee = 9.1 * $qty;
		} else {
			$fee = round((39 * $qty) * 100 / 18.5) / 100;
		}
		return $fee;
	}

	static public function getProductServiceFee($qty, $warehouse, $product){

		if($product == '70150K' ||
			$product == '70150C' ||
			$product == '70150SC' ||
			$product == '70370C' ||
			$product == '60020C' ||
			$product == '60020SC' ||
			$product == '60020K' ||
			$product == '60038C' ||
			$product == '60038K' ||
			$product == '60134C' ||
			$product == '60134C_XM' ||
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
			$product == '60233C' ||
			$product == '60233SC' ||
			$product == '60235C' ||
			$product == '60235SC' ||
			$product == '60236C' ||
			$product == '60236SC' ||
			$product == '60249C' ||
			$product == '60249SC' ||
			$product == '60253C' ||
			$product == '60253SC' ||
			$product == '70149C' ||
			$product == '70149SC'
		){
			if(0 == strcmp('xm', $warehouse)){
				$fee = 9.1 * $qty;
			} else {
				$fee = round((39 * $qty) * 100 / 18.5) / 100;
			}
		} else {
			if(0 == strcmp('xm', $warehouse)){
				$fee = 2.6 * $qty;
			} else {
				$fee = round((6.5 * $qty) * 100 / 18.5) / 100;
			}
		}

		return $fee;
	}

	static public function getAssembleServiceFee($qty, $warehouse, $product){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 7 * $qty;
		} else {
			$fee = round((30 * $qty) * 100 / 18.5) / 100;
		}

		return $fee;
	}

	static public function getShipFreightFee($org_fee, $region, $warehouse, $type, $weight, $box){

		if(ShippingType::T_SELFPICK == $type){
			return 0;
		}

		if(0 == strcmp('xm', $warehouse)){

			if(ShippingType::T_DPN == $type){
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
				$fee = ceil($fee);
			}

		} else {
			switch ($region) {
				case 'Taiwan': 
					if(ShippingType::T_BLACKCAT == $type){
						$fee = 0;
					} else {
						$fee = floor(ceil($weight / 18) * 11 * 20 / 18.5 * 10) / 10;
					}
				break;
				case 'GreenIsland': 
					if(ShippingType::T_BLACKCAT == $type){
						$fee = floor(ceil($weight / 18) * 19.8 * 20 / 18.5 * 10) / 10;
					} else {
						$fee = floor(ceil($weight / 18) * 11 * 20 / 18.5 * 10) / 10;
					}
				break;
				case 'Liuqiu_Henchun': 
					if(ShippingType::T_BLACKCAT == $type){
						$fee = floor(ceil($weight / 18) * 13.75 * 20 / 18.5 * 10) / 10;
					} else {
						$fee = floor(ceil($weight / 18) * 11 * 20 / 18.5 * 10) / 10;
					}
				break;
				case 'Korea': 
					$fee = round((floor($weight/20)*1780 + ($weight%20)*80 + 180)*1.1/18.5 + 0.0499, 1);
				break;
				case 'HongKong': 
					switch ($weight){
						case 1:	$fee = 6.8;	break;
						case 2:	$fee = 12.8;	break;
						case 3:	$fee = 18.5;	break;
						case 4:	$fee = 25;	break;
						case 5:	$fee = 31.4;	break;
						case 6:	$fee = 37.9;	break;
						case 7:	$fee = 44.3;	break;
						case 8:	$fee = 50.8;	break;
						case 9:	$fee = 57.2;	break;
						case 10:	$fee = 63.7;	break;
						case 11:	$fee = 70.1;	break;
						case 12:	$fee = 76.6;	break;
						case 13:	$fee = 83;	break;
						case 14:	$fee = 89.5;	break;
						case 15:	$fee = 95.9;	break;
						case 16:	$fee = 102.4;	break;
						case 17:	$fee = 108.8;	break;
						case 18:	$fee = 115.3;	break;
						case 19:	$fee = 121.7;	break;
						case 20:	$fee = 127.7;	break;
						case 21:	$fee = 134.1;	break;
						case 22:	$fee = 140.5;	break;
						case 23:	$fee = 146.9;	break;
						case 24:	$fee = 153.2;	break;
						case 25:	$fee = 159.6;	break;
						case 26:	$fee = 166;	break;
						case 27:	$fee = 172.4;	break;
						case 28:	$fee = 178.8;	break;
						case 29:	$fee = 185.2;	break;
						case 30:	$fee = 191.5;	break;
						case 31:	$fee = 197.9;	break;
						case 32:	$fee = 204.3;	break;
						case 33:	$fee = 210.7;	break;
						case 34:	$fee = 217.1;	break;
						case 35:	$fee = 223.5;	break;
						case 36:	$fee = 229.8;	break;
						case 37:	$fee = 236.2;	break;
						case 38:	$fee = 242.6;	break;
						case 39:	$fee = 249;	break;
						case 40:	$fee = 255.4;	break;
						case 41:	$fee = 261.8;	break;
						case 42:	$fee = 268.1;	break;
						case 43:	$fee = 274.5;	break;
						case 44:	$fee = 280.9;	break;
						case 45:	$fee = 287.3;	break;
						case 46:	$fee = 293.7;	break;
						case 47:	$fee = 300;	break;
						case 48:	$fee = 306.4;	break;
						case 49:	$fee = 312.8;	break;
						case 50:	$fee = 319.2;	break;
						case 51:	$fee = 325.6;	break;
						case 52:	$fee = 332;	break;
						case 53:	$fee = 338.3;	break;
						case 54:	$fee = 344.7;	break;
						case 55:	$fee = 351.1;	break;
						case 56:	$fee = 357.5;	break;
						case 57:	$fee = 363.9;	break;
						case 58:	$fee = 370.3;	break;
						case 59:	$fee = 376.6;	break;
						case 60:	$fee = 383;	break;
						case 61:	$fee = 389.4;	break;
						case 62:	$fee = 395.8;	break;
						case 63:	$fee = 402.2;	break;
						case 64:	$fee = 408.6;	break;
						case 65:	$fee = 414.9;	break;
						case 66:	$fee = 421.3;	break;
						case 67:	$fee = 427.7;	break;
						case 68:	$fee = 434.1;	break;
						case 69:	$fee = 440.5;	break;
						case 70:	$fee = 446.9;	break;
						case 71:	$fee = 453.2;	break;
						case 72:	$fee = 459.6;	break;
						case 73:	$fee = 466;	break;
						case 74:	$fee = 472.4;	break;
						case 75:	$fee = 478.8;	break;
						case 76:	$fee = 485.2;	break;
						case 77:	$fee = 491.5;	break;
						case 78:	$fee = 497.9;	break;
						case 79:	$fee = 504.3;	break;
						case 80:	$fee = 510.7;	break;
						case 81:	$fee = 517.1;	break;
						case 82:	$fee = 523.5;	break;
						case 83:	$fee = 529.8;	break;
						case 84:	$fee = 536.2;	break;
						case 85:	$fee = 542.6;	break;
						case 86:	$fee = 549;	break;
						case 87:	$fee = 555.4;	break;
						case 88:	$fee = 561.8;	break;
						case 89:	$fee = 568.1;	break;
						case 90:	$fee = 574.5;	break;
						case 91:	$fee = 580.9;	break;
						case 92:	$fee = 587.3;	break;
						case 93:	$fee = 593.7;	break;
						case 94:	$fee = 600;	break;
						case 95:	$fee = 606.4;	break;
						case 96:	$fee = 612.8;	break;
						case 97:	$fee = 619.2;	break;
						case 98:	$fee = 625.6;	break;
						case 99:	$fee = 632;	break;
						case 100:	$fee = 638.3;	break;
						case 101:	$fee = 644.7;	break;
						case 102:	$fee = 651.1;	break;
						case 103:	$fee = 657.5;	break;
						case 104:	$fee = 663.9;	break;
						case 105:	$fee = 670.3;	break;
						case 106:	$fee = 676.6;	break;
						case 107:	$fee = 683;	break;
						case 108:	$fee = 689.4;	break;
						case 109:	$fee = 695.8;	break;
						case 110:	$fee = 702.2;	break;
						case 111:	$fee = 708.6;	break;
						case 112:	$fee = 714.9;	break;
						case 113:	$fee = 721.3;	break;
						case 114:	$fee = 727.7;	break;
						case 115:	$fee = 734.1;	break;
						case 116:	$fee = 740.5;	break;
						case 117:	$fee = 746.9;	break;
						case 118:	$fee = 753.2;	break;
						case 119:	$fee = 759.6;	break;
						case 120:	$fee = 766;	break;
						case 121:	$fee = 772.4;	break;
						case 122:	$fee = 778.8;	break;
						case 123:	$fee = 785.2;	break;
						case 124:	$fee = 791.5;	break;
						case 125:	$fee = 797.9;	break;
						case 126:	$fee = 804.3;	break;
						case 127:	$fee = 810.7;	break;
						case 128:	$fee = 817.1;	break;
						case 129:	$fee = 823.5;	break;
						case 130:	$fee = 829.8;	break;
						case 131:	$fee = 836.2;	break;
						case 132:	$fee = 842.6;	break;
						case 133:	$fee = 849;	break;
						case 134:	$fee = 855.4;	break;
						case 135:	$fee = 861.8;	break;
						case 136:	$fee = 868.1;	break;
						case 137:	$fee = 874.5;	break;
						case 138:	$fee = 880.9;	break;
						case 139:	$fee = 887.3;	break;
						case 140:	$fee = 893.7;	break;
						case 141:	$fee = 900;	break;
						case 142:	$fee = 906.4;	break;
						case 143:	$fee = 912.8;	break;
						case 144:	$fee = 919.2;	break;
						case 145:	$fee = 925.6;	break;
						case 146:	$fee = 932;	break;
						case 147:	$fee = 938.3;	break;
						case 148:	$fee = 944.7;	break;
						case 149:	$fee = 951.1;	break;
						case 150:	$fee = 957.5;	break;
						case 151:	$fee = 963.9;	break;
						case 152:	$fee = 970.3;	break;
						case 153:	$fee = 976.6;	break;
						case 154:	$fee = 983;	break;
						case 155:	$fee = 989.4;	break;
						case 156:	$fee = 995.8;	break;
						case 157:	$fee = 1002.2;	break;
						case 158:	$fee = 1008.6;	break;
						case 159:	$fee = 1014.9;	break;
						case 160:	$fee = 1021.3;	break;
						case 161:	$fee = 1027.7;	break;
						case 162:	$fee = 1034.1;	break;
						case 163:	$fee = 1040.5;	break;
						case 164:	$fee = 1046.9;	break;
						case 165:	$fee = 1053.2;	break;
						case 166:	$fee = 1059.6;	break;
						case 167:	$fee = 1066;	break;
						case 168:	$fee = 1072.4;	break;
						case 169:	$fee = 1078.8;	break;
						case 170:	$fee = 1085.2;	break;
						case 171:	$fee = 1091.5;	break;
						case 172:	$fee = 1097.9;	break;
						case 173:	$fee = 1104.3;	break;
						case 174:	$fee = 1110.7;	break;
						case 175:	$fee = 1117.1;	break;
						case 176:	$fee = 1123.5;	break;
						case 177:	$fee = 1129.8;	break;
						case 178:	$fee = 1136.2;	break;
						case 179:	$fee = 1142.6;	break;
						case 180:	$fee = 1149;	break;
						case 181:	$fee = 1155.4;	break;
						case 182:	$fee = 1161.8;	break;
						case 183:	$fee = 1168.1;	break;
						case 184:	$fee = 1174.5;	break;
						case 185:	$fee = 1180.9;	break;
						case 186:	$fee = 1187.3;	break;
						case 187:	$fee = 1193.7;	break;
						case 188:	$fee = 1200;	break;
						case 189:	$fee = 1206.4;	break;
						case 190:	$fee = 1212.8;	break;
						case 191:	$fee = 1219.2;	break;
						case 192:	$fee = 1225.6;	break;
						case 193:	$fee = 1232;	break;
						case 194:	$fee = 1238.3;	break;
						case 195:	$fee = 1244.7;	break;
						case 196:	$fee = 1251.1;	break;
						case 197:	$fee = 1257.5;	break;
						case 198:	$fee = 1263.9;	break;
						case 199:	$fee = 1270.3;	break;
						case 200:	$fee = 1276.6;	break;
						case 201:	$fee = 1283;	break;
						case 202:	$fee = 1289.4;	break;
						case 203:	$fee = 1295.8;	break;
						case 204:	$fee = 1302.2;	break;
						case 205:	$fee = 1308.6;	break;
						case 206:	$fee = 1314.9;	break;
						case 207:	$fee = 1321.3;	break;
						case 208:	$fee = 1327.7;	break;
						case 209:	$fee = 1334.1;	break;
						case 210:	$fee = 1340.5;	break;
						case 211:	$fee = 1346.9;	break;
						case 212:	$fee = 1353.2;	break;
						case 213:	$fee = 1359.6;	break;
						case 214:	$fee = 1366;	break;
						case 215:	$fee = 1372.4;	break;
						case 216:	$fee = 1378.8;	break;
						case 217:	$fee = 1385.2;	break;
						case 218:	$fee = 1391.5;	break;
						case 219:	$fee = 1397.9;	break;
						case 220:	$fee = 1404.3;	break;
						case 221:	$fee = 1410.7;	break;
						case 222:	$fee = 1417.1;	break;
						case 223:	$fee = 1423.5;	break;
						case 224:	$fee = 1429.8;	break;
						case 225:	$fee = 1436.2;	break;
						case 226:	$fee = 1442.6;	break;
						case 227:	$fee = 1449;	break;
						case 228:	$fee = 1455.4;	break;
						case 229:	$fee = 1461.8;	break;
						case 230:	$fee = 1468.1;	break;
						case 231:	$fee = 1474.5;	break;
						case 232:	$fee = 1480.9;	break;
						case 233:	$fee = 1487.3;	break;
						case 234:	$fee = 1493.7;	break;
						case 235:	$fee = 1500;	break;
						case 236:	$fee = 1506.4;	break;
						case 237:	$fee = 1512.8;	break;
						case 238:	$fee = 1519.2;	break;
						case 239:	$fee = 1525.6;	break;
						case 240:	$fee = 1532;	break;
						case 241:	$fee = 1538.3;	break;
						case 242:	$fee = 1544.7;	break;
						case 243:	$fee = 1551.1;	break;
						case 244:	$fee = 1557.5;	break;
						case 245:	$fee = 1563.9;	break;
						case 246:	$fee = 1570.3;	break;
						case 247:	$fee = 1576.6;	break;
						case 248:	$fee = 1583;	break;
						case 249:	$fee = 1589.4;	break;
						case 250:	$fee = 1595.8;	break;
						case 251:	$fee = 1602.2;	break;
						case 252:	$fee = 1608.6;	break;
						case 253:	$fee = 1614.9;	break;
						case 254:	$fee = 1621.3;	break;
						case 255:	$fee = 1627.7;	break;
						case 256:	$fee = 1634.1;	break;
						case 257:	$fee = 1640.5;	break;
						case 258:	$fee = 1646.9;	break;
						case 259:	$fee = 1653.2;	break;
						case 260:	$fee = 1659.6;	break;
						case 261:	$fee = 1666;	break;
						case 262:	$fee = 1672.4;	break;
						case 263:	$fee = 1678.8;	break;
						case 264:	$fee = 1685.2;	break;
						case 265:	$fee = 1691.5;	break;
						case 266:	$fee = 1697.9;	break;
						case 267:	$fee = 1704.3;	break;
						case 268:	$fee = 1710.7;	break;
						case 269:	$fee = 1717.1;	break;
						case 270:	$fee = 1723.5;	break;
						case 271:	$fee = 1729.8;	break;
						case 272:	$fee = 1736.2;	break;
						case 273:	$fee = 1742.6;	break;
						case 274:	$fee = 1749;	break;
						case 275:	$fee = 1755.4;	break;
						case 276:	$fee = 1761.8;	break;
						case 277:	$fee = 1768.1;	break;
						case 278:	$fee = 1774.5;	break;
						case 279:	$fee = 1780.9;	break;
						case 280:	$fee = 1787.3;	break;
						case 281:	$fee = 1793.7;	break;
						case 282:	$fee = 1800;	break;
						case 283:	$fee = 1806.4;	break;
						case 284:	$fee = 1812.8;	break;
						case 285:	$fee = 1819.2;	break;
						case 286:	$fee = 1825.6;	break;
						case 287:	$fee = 1832;	break;
						case 288:	$fee = 1838.3;	break;
						case 289:	$fee = 1844.7;	break;
						case 290:	$fee = 1851.1;	break;
						case 291:	$fee = 1857.5;	break;
						case 292:	$fee = 1863.9;	break;
						case 293:	$fee = 1870.3;	break;
						case 294:	$fee = 1876.6;	break;
						case 295:	$fee = 1883;	break;
						case 296:	$fee = 1889.4;	break;
						case 297:	$fee = 1895.8;	break;
						case 298:	$fee = 1902.2;	break;
						case 299:	$fee = 1908.6;	break;
						case 300:	$fee = 1914.9;	break;
						case 301:	$fee = 1921.3;	break;
						case 302:	$fee = 1927.7;	break;
						case 303:	$fee = 1934.1;	break;
						case 304:	$fee = 1940.5;	break;
						case 305:	$fee = 1946.9;	break;
						case 306:	$fee = 1953.2;	break;
						case 307:	$fee = 1959.6;	break;
						case 308:	$fee = 1966;	break;
						case 309:	$fee = 1972.4;	break;
						case 310:	$fee = 1978.8;	break;
						case 311:	$fee = 1985.2;	break;
						case 312:	$fee = 1991.5;	break;
						case 313:	$fee = 1997.9;	break;
						case 314:	$fee = 2004.3;	break;
						case 315:	$fee = 2010.7;	break;
						case 316:	$fee = 2017.1;	break;
						case 317:	$fee = 2023.5;	break;
						case 318:	$fee = 2029.8;	break;
						case 319:	$fee = 2036.2;	break;
						case 320:	$fee = 2042.6;	break;
						case 321:	$fee = 2049;	break;
						case 322:	$fee = 2055.4;	break;
						case 323:	$fee = 2061.8;	break;
						case 324:	$fee = 2068.1;	break;
						case 325:	$fee = 2074.5;	break;
						case 326:	$fee = 2080.9;	break;
						case 327:	$fee = 2087.3;	break;
						case 328:	$fee = 2093.7;	break;
						case 329:	$fee = 2100;	break;
						case 330:	$fee = 2106.4;	break;
						case 331:	$fee = 2112.8;	break;
						case 332:	$fee = 2119.2;	break;
						case 333:	$fee = 2125.6;	break;
						case 334:	$fee = 2132;	break;
						case 335:	$fee = 2138.3;	break;
						case 336:	$fee = 2144.7;	break;
						case 337:	$fee = 2151.1;	break;
						case 338:	$fee = 2157.5;	break;
						case 339:	$fee = 2163.9;	break;
						case 340:	$fee = 2170.3;	break;
						case 341:	$fee = 2176.6;	break;
						case 342:	$fee = 2183;	break;
						case 343:	$fee = 2189.4;	break;
						case 344:	$fee = 2195.8;	break;
						case 345:	$fee = 2202.2;	break;
						case 346:	$fee = 2208.6;	break;
						case 347:	$fee = 2214.9;	break;
						case 348:	$fee = 2221.3;	break;
						case 349:	$fee = 2227.7;	break;
						case 350:	$fee = 2234.1;	break;
						case 351:	$fee = 2240.5;	break;
						case 352:	$fee = 2246.9;	break;
						case 353:	$fee = 2253.2;	break;
						case 354:	$fee = 2259.6;	break;
						case 355:	$fee = 2266;	break;
						case 356:	$fee = 2272.4;	break;
						case 357:	$fee = 2278.8;	break;
						case 358:	$fee = 2285.2;	break;
						case 359:	$fee = 2291.5;	break;
						case 360:	$fee = 2297.9;	break;
						case 361:	$fee = 2304.3;	break;
						case 362:	$fee = 2310.7;	break;
						case 363:	$fee = 2317.1;	break;
						case 364:	$fee = 2323.5;	break;
						case 365:	$fee = 2329.8;	break;
						case 366:	$fee = 2336.2;	break;
						case 367:	$fee = 2342.6;	break;
						case 368:	$fee = 2349;	break;
						case 369:	$fee = 2355.4;	break;
						case 370:	$fee = 2361.7;	break;
						case 371:	$fee = 2368.1;	break;
						case 372:	$fee = 2374.5;	break;
						case 373:	$fee = 2380.9;	break;
						case 374:	$fee = 2387.3;	break;
						case 375:	$fee = 2393.7;	break;
						case 376:	$fee = 2400;	break;
						case 377:	$fee = 2406.4;	break;
						case 378:	$fee = 2412.8;	break;
						case 379:	$fee = 2419.2;	break;
						case 380:	$fee = 2425.6;	break;
						case 381:	$fee = 2432;	break;
						case 382:	$fee = 2438.3;	break;
						case 383:	$fee = 2444.7;	break;
						case 384:	$fee = 2451.1;	break;
						case 385:	$fee = 2457.5;	break;
						case 386:	$fee = 2463.9;	break;
						case 387:	$fee = 2470.3;	break;
						case 388:	$fee = 2476.6;	break;
						case 389:	$fee = 2483;	break;
						case 390:	$fee = 2489.4;	break;
						case 391:	$fee = 2495.8;	break;
						case 392:	$fee = 2502.2;	break;
						case 393:	$fee = 2508.6;	break;
						case 394:	$fee = 2514.9;	break;
						case 395:	$fee = 2521.3;	break;
						case 396:	$fee = 2527.7;	break;
						case 397:	$fee = 2534.1;	break;
						case 398:	$fee = 2540.5;	break;
						case 399:	$fee = 2546.9;	break;
						case 400:	$fee = 2553.2;	break;
						case 401:	$fee = 2559.6;	break;
						case 402:	$fee = 2566;	break;
						case 403:	$fee = 2572.4;	break;
						case 404:	$fee = 2578.8;	break;
						case 405:	$fee = 2585.2;	break;
						case 406:	$fee = 2591.5;	break;
						case 407:	$fee = 2597.9;	break;
						case 408:	$fee = 2604.3;	break;
						case 409:	$fee = 2610.7;	break;
						case 410:	$fee = 2617.1;	break;
						case 411:	$fee = 2623.5;	break;
						case 412:	$fee = 2629.8;	break;
						case 413:	$fee = 2636.2;	break;
						case 414:	$fee = 2642.6;	break;
						case 415:	$fee = 2649;	break;
						case 416:	$fee = 2655.4;	break;
						case 417:	$fee = 2661.7;	break;
						case 418:	$fee = 2668.1;	break;
						case 419:	$fee = 2674.5;	break;
						case 420:	$fee = 2680.9;	break;
						case 421:	$fee = 2687.3;	break;
						case 422:	$fee = 2693.7;	break;
						case 423:	$fee = 2700;	break;
						case 424:	$fee = 2706.4;	break;
						case 425:	$fee = 2712.8;	break;
						case 426:	$fee = 2719.2;	break;
						case 427:	$fee = 2725.6;	break;
						case 428:	$fee = 2732;	break;
						case 429:	$fee = 2738.3;	break;
						case 430:	$fee = 2744.7;	break;
						case 431:	$fee = 2751.1;	break;
						case 432:	$fee = 2757.5;	break;
						case 433:	$fee = 2763.9;	break;
						case 434:	$fee = 2770.3;	break;
						case 435:	$fee = 2776.6;	break;
						case 436:	$fee = 2783;	break;
						case 437:	$fee = 2789.4;	break;
						case 438:	$fee = 2795.8;	break;
						case 439:	$fee = 2802.2;	break;
						case 440:	$fee = 2808.6;	break;
						case 441:	$fee = 2814.9;	break;
						case 442:	$fee = 2821.3;	break;
						case 443:	$fee = 2827.7;	break;
						case 444:	$fee = 2834.1;	break;
						case 445:	$fee = 2840.5;	break;
						case 446:	$fee = 2846.9;	break;
						case 447:	$fee = 2853.2;	break;
						case 448:	$fee = 2859.6;	break;
						case 449:	$fee = 2866;	break;
						case 450:	$fee = 2872.4;	break;
						case 451:	$fee = 2878.8;	break;
						case 452:	$fee = 2885.2;	break;
						case 453:	$fee = 2891.5;	break;
						case 454:	$fee = 2897.9;	break;
						case 455:	$fee = 2904.3;	break;
						case 456:	$fee = 2910.7;	break;
						case 457:	$fee = 2917.1;	break;
						case 458:	$fee = 2923.5;	break;
						case 459:	$fee = 2929.8;	break;
						case 460:	$fee = 2936.2;	break;
						case 461:	$fee = 2942.6;	break;
						case 462:	$fee = 2949;	break;
						case 463:	$fee = 2955.4;	break;
						case 464:	$fee = 2961.7;	break;
						case 465:	$fee = 2968.1;	break;
						case 466:	$fee = 2974.5;	break;
						case 467:	$fee = 2980.9;	break;
						case 468:	$fee = 2987.3;	break;
						case 469:	$fee = 2993.7;	break;
						case 470:	$fee = 3000;	break;
						case 471:	$fee = 3006.4;	break;
						case 472:	$fee = 3012.8;	break;
						case 473:	$fee = 3019.2;	break;
						case 474:	$fee = 3025.6;	break;
						case 475:	$fee = 3032;	break;
						case 476:	$fee = 3038.3;	break;
						case 477:	$fee = 3044.7;	break;
						case 478:	$fee = 3051.1;	break;
						case 479:	$fee = 3057.5;	break;
						case 480:	$fee = 3063.9;	break;
						case 481:	$fee = 3070.3;	break;
						case 482:	$fee = 3076.6;	break;
						case 483:	$fee = 3083;	break;
						case 484:	$fee = 3089.4;	break;
						case 485:	$fee = 3095.8;	break;
						case 486:	$fee = 3102.2;	break;
						case 487:	$fee = 3108.6;	break;
						case 488:	$fee = 3114.9;	break;
						case 489:	$fee = 3121.3;	break;
						case 490:	$fee = 3127.7;	break;
						case 491:	$fee = 3134.1;	break;
						case 492:	$fee = 3140.5;	break;
						case 493:	$fee = 3146.9;	break;
						case 494:	$fee = 3153.2;	break;
						case 495:	$fee = 3159.6;	break;
						case 496:	$fee = 3166;	break;
						case 497:	$fee = 3172.4;	break;
						case 498:	$fee = 3178.8;	break;
						case 499:	$fee = 3185.2;	break;
						case 500:	$fee = 3191.5;	break;
						case 501:	$fee = 3197.9;	break;
						case 502:	$fee = 3204.3;	break;
						case 503:	$fee = 3210.7;	break;
						case 504:	$fee = 3217.1;	break;
						case 505:	$fee = 3223.5;	break;
						case 506:	$fee = 3229.8;	break;
						case 507:	$fee = 3236.2;	break;
						case 508:	$fee = 3242.6;	break;
						case 509:	$fee = 3249;	break;
						case 510:	$fee = 3255.4;	break;
						case 511:	$fee = 3261.7;	break;
						case 512:	$fee = 3268.1;	break;
						case 513:	$fee = 3274.5;	break;
						case 514:	$fee = 3280.9;	break;
						case 515:	$fee = 3287.3;	break;
						case 516:	$fee = 3293.7;	break;
						case 517:	$fee = 3300;	break;
						case 518:	$fee = 3306.4;	break;
						case 519:	$fee = 3312.8;	break;
						case 520:	$fee = 3319.2;	break;
						case 521:	$fee = 3325.6;	break;
						case 522:	$fee = 3332;	break;
						case 523:	$fee = 3338.3;	break;
						case 524:	$fee = 3344.7;	break;
						case 525:	$fee = 3351.1;	break;
						case 526:	$fee = 3357.5;	break;
						case 527:	$fee = 3363.9;	break;
						case 528:	$fee = 3370.3;	break;
						case 529:	$fee = 3376.6;	break;
						case 530:	$fee = 3383;	break;
						case 531:	$fee = 3389.4;	break;
						case 532:	$fee = 3395.8;	break;
						case 533:	$fee = 3402.2;	break;
						case 534:	$fee = 3408.6;	break;
						case 535:	$fee = 3414.9;	break;
						case 536:	$fee = 3421.3;	break;
						case 537:	$fee = 3427.7;	break;
						case 538:	$fee = 3434.1;	break;
						case 539:	$fee = 3440.5;	break;
						case 540:	$fee = 3446.9;	break;
						case 541:	$fee = 3453.2;	break;
						case 542:	$fee = 3459.6;	break;
						case 543:	$fee = 3466;	break;
						case 544:	$fee = 3472.4;	break;
						case 545:	$fee = 3478.8;	break;
						case 546:	$fee = 3485.2;	break;
						case 547:	$fee = 3491.5;	break;
						case 548:	$fee = 3497.9;	break;
						case 549:	$fee = 3504.3;	break;
						case 550:	$fee = 3510.7;	break;
						case 551:	$fee = 3517.1;	break;
						case 552:	$fee = 3523.5;	break;
						case 553:	$fee = 3529.8;	break;
						case 554:	$fee = 3536.2;	break;
						case 555:	$fee = 3542.6;	break;
						case 556:	$fee = 3549;	break;
						case 557:	$fee = 3555.4;	break;
						case 558:	$fee = 3561.7;	break;
						case 559:	$fee = 3568.1;	break;
						case 560:	$fee = 3574.5;	break;
						case 561:	$fee = 3580.9;	break;
						case 562:	$fee = 3587.3;	break;
						case 563:	$fee = 3593.7;	break;
						case 564:	$fee = 3600;	break;
						case 565:	$fee = 3606.4;	break;
						case 566:	$fee = 3612.8;	break;
						case 567:	$fee = 3619.2;	break;
						case 568:	$fee = 3625.6;	break;
						case 569:	$fee = 3632;	break;
						case 570:	$fee = 3638.3;	break;
						case 571:	$fee = 3644.7;	break;
						case 572:	$fee = 3651.1;	break;
						case 573:	$fee = 3657.5;	break;
						case 574:	$fee = 3663.9;	break;
						case 575:	$fee = 3670.3;	break;
						case 576:	$fee = 3676.6;	break;
						case 577:	$fee = 3683;	break;
						case 578:	$fee = 3689.4;	break;
						case 579:	$fee = 3695.8;	break;
						case 580:	$fee = 3702.2;	break;
						case 581:	$fee = 3708.6;	break;
						case 582:	$fee = 3714.9;	break;
						case 583:	$fee = 3721.3;	break;
						case 584:	$fee = 3727.7;	break;
						case 585:	$fee = 3734.1;	break;
						case 586:	$fee = 3740.5;	break;
						case 587:	$fee = 3746.9;	break;
						case 588:	$fee = 3753.2;	break;
						case 589:	$fee = 3759.6;	break;
						case 590:	$fee = 3766;	break;
						case 591:	$fee = 3772.4;	break;
						case 592:	$fee = 3778.8;	break;
						case 593:	$fee = 3785.2;	break;
						case 594:	$fee = 3791.5;	break;
						case 595:	$fee = 3797.9;	break;
						case 596:	$fee = 3804.3;	break;
						case 597:	$fee = 3810.7;	break;
						case 598:	$fee = 3817.1;	break;
						case 599:	$fee = 3823.5;	break;
						case 600:	$fee = 3829.8;	break;
						case 601:	$fee = 3836.2;	break;
						case 602:	$fee = 3842.6;	break;
						case 603:	$fee = 3849;	break;
						case 604:	$fee = 3855.4;	break;
						case 605:	$fee = 3861.7;	break;
						case 606:	$fee = 3868.1;	break;
						case 607:	$fee = 3874.5;	break;
						case 608:	$fee = 3880.9;	break;
						case 609:	$fee = 3887.3;	break;
						case 610:	$fee = 3893.7;	break;
						case 611:	$fee = 3900;	break;
						case 612:	$fee = 3906.4;	break;
						case 613:	$fee = 3912.8;	break;
						case 614:	$fee = 3919.2;	break;
						case 615:	$fee = 3925.6;	break;
						case 616:	$fee = 3932;	break;
						case 617:	$fee = 3938.3;	break;
						case 618:	$fee = 3944.7;	break;
						case 619:	$fee = 3951.1;	break;
						case 620:	$fee = 3957.5;	break;
						case 621:	$fee = 3963.9;	break;
						case 622:	$fee = 3970.3;	break;
						case 623:	$fee = 3976.6;	break;
						case 624:	$fee = 3983;	break;
						case 625:	$fee = 3989.4;	break;
						case 626:	$fee = 3995.8;	break;
						case 627:	$fee = 4002.2;	break;
						case 628:	$fee = 4008.6;	break;
						case 629:	$fee = 4014.9;	break;
						case 630:	$fee = 4021.3;	break;
						case 631:	$fee = 4027.7;	break;
						case 632:	$fee = 4034.1;	break;
						case 633:	$fee = 4040.5;	break;
						case 634:	$fee = 4046.9;	break;
						case 635:	$fee = 4053.2;	break;
						case 636:	$fee = 4059.6;	break;
						case 637:	$fee = 4066;	break;
						case 638:	$fee = 4072.4;	break;
						case 639:	$fee = 4078.8;	break;
						case 640:	$fee = 4085.2;	break;
						case 641:	$fee = 4091.5;	break;
						case 642:	$fee = 4097.9;	break;
						case 643:	$fee = 4104.3;	break;
						case 644:	$fee = 4110.7;	break;
						case 645:	$fee = 4117.1;	break;
						case 646:	$fee = 4123.5;	break;
						case 647:	$fee = 4129.8;	break;
						case 648:	$fee = 4136.2;	break;
						case 649:	$fee = 4142.6;	break;
						case 650:	$fee = 4149;	break;
						case 651:	$fee = 4155.4;	break;
						case 652:	$fee = 4161.7;	break;
						case 653:	$fee = 4168.1;	break;
						case 654:	$fee = 4174.5;	break;
						case 655:	$fee = 4180.9;	break;
						case 656:	$fee = 4187.3;	break;
						case 657:	$fee = 4193.7;	break;
						case 658:	$fee = 4200;	break;
						case 659:	$fee = 4206.4;	break;
						case 660:	$fee = 4212.8;	break;
						case 661:	$fee = 4219.2;	break;
						case 662:	$fee = 4225.6;	break;
						case 663:	$fee = 4232;	break;
						case 664:	$fee = 4238.3;	break;
						case 665:	$fee = 4244.7;	break;
						case 666:	$fee = 4251.1;	break;
						case 667:	$fee = 4257.5;	break;
						case 668:	$fee = 4263.9;	break;
						case 669:	$fee = 4270.3;	break;
						case 670:	$fee = 4276.6;	break;
						case 671:	$fee = 4283;	break;
						case 672:	$fee = 4289.4;	break;
						case 673:	$fee = 4295.8;	break;
						case 674:	$fee = 4302.2;	break;
						case 675:	$fee = 4308.6;	break;
						case 676:	$fee = 4314.9;	break;
						case 677:	$fee = 4321.3;	break;
						case 678:	$fee = 4327.7;	break;
						case 679:	$fee = 4334.1;	break;
						case 680:	$fee = 4340.5;	break;
						case 681:	$fee = 4346.9;	break;
						case 682:	$fee = 4353.2;	break;
						case 683:	$fee = 4359.6;	break;
						case 684:	$fee = 4366;	break;
						case 685:	$fee = 4372.4;	break;
						case 686:	$fee = 4378.8;	break;
						case 687:	$fee = 4385.2;	break;
						case 688:	$fee = 4391.5;	break;
						case 689:	$fee = 4397.9;	break;
						case 690:	$fee = 4404.3;	break;
						case 691:	$fee = 4410.7;	break;
						case 692:	$fee = 4417.1;	break;
						case 693:	$fee = 4423.5;	break;
						case 694:	$fee = 4429.8;	break;
						case 695:	$fee = 4436.2;	break;
						case 696:	$fee = 4442.6;	break;
						case 697:	$fee = 4449;	break;
						case 698:	$fee = 4455.4;	break;
						case 699:	$fee = 4461.7;	break;
						case 700:	$fee = 4468.1;	break;
						case 701:	$fee = 4474.5;	break;
						case 702:	$fee = 4480.9;	break;
						case 703:	$fee = 4487.3;	break;
						case 704:	$fee = 4493.7;	break;
						case 705:	$fee = 4500;	break;
						case 706:	$fee = 4506.4;	break;
						case 707:	$fee = 4512.8;	break;
						case 708:	$fee = 4519.2;	break;
						case 709:	$fee = 4525.6;	break;
						case 710:	$fee = 4532;	break;
						case 711:	$fee = 4538.3;	break;
						case 712:	$fee = 4544.7;	break;
						case 713:	$fee = 4551.1;	break;
						case 714:	$fee = 4557.5;	break;
						case 715:	$fee = 4563.9;	break;
						case 716:	$fee = 4570.3;	break;
						case 717:	$fee = 4576.6;	break;
						case 718:	$fee = 4583;	break;
						case 719:	$fee = 4589.4;	break;
						case 720:	$fee = 4595.8;	break;
						case 721:	$fee = 4602.2;	break;
						case 722:	$fee = 4608.6;	break;
						case 723:	$fee = 4614.9;	break;
						case 724:	$fee = 4621.3;	break;
						case 725:	$fee = 4627.7;	break;
						case 726:	$fee = 4634.1;	break;
						case 727:	$fee = 4640.5;	break;
						case 728:	$fee = 4646.9;	break;
						case 729:	$fee = 4653.2;	break;
						case 730:	$fee = 4659.6;	break;
						case 731:	$fee = 4666;	break;
						case 732:	$fee = 4672.4;	break;
						case 733:	$fee = 4678.8;	break;
						case 734:	$fee = 4685.2;	break;
						case 735:	$fee = 4691.5;	break;
						case 736:	$fee = 4697.9;	break;
						case 737:	$fee = 4704.3;	break;
						case 738:	$fee = 4710.7;	break;
						case 739:	$fee = 4717.1;	break;
						case 740:	$fee = 4723.4;	break;
						case 741:	$fee = 4729.8;	break;
						case 742:	$fee = 4736.2;	break;
						case 743:	$fee = 4742.6;	break;
						case 744:	$fee = 4749;	break;
						case 745:	$fee = 4755.4;	break;
						case 746:	$fee = 4761.7;	break;
						case 747:	$fee = 4768.1;	break;
						case 748:	$fee = 4774.5;	break;
						case 749:	$fee = 4780.9;	break;
						case 750:	$fee = 4787.3;	break;
						case 751:	$fee = 4793.7;	break;
						case 752:	$fee = 4800;	break;
						case 753:	$fee = 4806.4;	break;
						case 754:	$fee = 4812.8;	break;
						case 755:	$fee = 4819.2;	break;
						case 756:	$fee = 4825.6;	break;
						case 757:	$fee = 4832;	break;
						case 758:	$fee = 4838.3;	break;
						case 759:	$fee = 4844.7;	break;
						case 760:	$fee = 4851.1;	break;
						case 761:	$fee = 4857.5;	break;
						case 762:	$fee = 4863.9;	break;
						case 763:	$fee = 4870.3;	break;
						case 764:	$fee = 4876.6;	break;
						case 765:	$fee = 4883;	break;
						case 766:	$fee = 4889.4;	break;
						case 767:	$fee = 4895.8;	break;
						case 768:	$fee = 4902.2;	break;
						case 769:	$fee = 4908.6;	break;
						case 770:	$fee = 4914.9;	break;
						case 771:	$fee = 4921.3;	break;
						case 772:	$fee = 4927.7;	break;
						case 773:	$fee = 4934.1;	break;
						case 774:	$fee = 4940.5;	break;
						case 775:	$fee = 4946.9;	break;
						case 776:	$fee = 4953.2;	break;
						case 777:	$fee = 4959.6;	break;
						case 778:	$fee = 4966;	break;
						case 779:	$fee = 4972.4;	break;
						case 780:	$fee = 4978.8;	break;
						case 781:	$fee = 4985.2;	break;
						case 782:	$fee = 4991.5;	break;
						case 783:	$fee = 4997.9;	break;
						case 784:	$fee = 5004.3;	break;
						case 785:	$fee = 5010.7;	break;
						case 786:	$fee = 5017.1;	break;
						case 787:	$fee = 5023.4;	break;
						case 788:	$fee = 5029.8;	break;
						case 789:	$fee = 5036.2;	break;
						case 790:	$fee = 5042.6;	break;
						case 791:	$fee = 5049;	break;
						case 792:	$fee = 5055.4;	break;
						case 793:	$fee = 5061.7;	break;
						case 794:	$fee = 5068.1;	break;
						case 795:	$fee = 5074.5;	break;
						case 796:	$fee = 5080.9;	break;
						case 797:	$fee = 5087.3;	break;
						case 798:	$fee = 5093.7;	break;
						case 799:	$fee = 5100;	break;
						case 800:	$fee = 5106.4;	break;
						case 801:	$fee = 5112.8;	break;
						case 802:	$fee = 5119.2;	break;
						case 803:	$fee = 5125.6;	break;
						case 804:	$fee = 5132;	break;
						case 805:	$fee = 5138.3;	break;
						case 806:	$fee = 5144.7;	break;
						case 807:	$fee = 5151.1;	break;
						case 808:	$fee = 5157.5;	break;
						case 809:	$fee = 5163.9;	break;
						case 810:	$fee = 5170.3;	break;
						case 811:	$fee = 5176.6;	break;
						case 812:	$fee = 5183;	break;
						case 813:	$fee = 5189.4;	break;
						case 814:	$fee = 5195.8;	break;
						case 815:	$fee = 5202.2;	break;
						case 816:	$fee = 5208.6;	break;
						case 817:	$fee = 5214.9;	break;
						case 818:	$fee = 5221.3;	break;
						case 819:	$fee = 5227.7;	break;
						case 820:	$fee = 5234.1;	break;
						case 821:	$fee = 5240.5;	break;
						case 822:	$fee = 5246.9;	break;
						case 823:	$fee = 5253.2;	break;
						case 824:	$fee = 5259.6;	break;
						case 825:	$fee = 5266;	break;
						case 826:	$fee = 5272.4;	break;
						case 827:	$fee = 5278.8;	break;
						case 828:	$fee = 5285.2;	break;
						case 829:	$fee = 5291.5;	break;
						case 830:	$fee = 5297.9;	break;
						case 831:	$fee = 5304.3;	break;
						case 832:	$fee = 5310.7;	break;
						case 833:	$fee = 5317.1;	break;
						case 834:	$fee = 5323.4;	break;
						case 835:	$fee = 5329.8;	break;
						case 836:	$fee = 5336.2;	break;
						case 837:	$fee = 5342.6;	break;
						case 838:	$fee = 5349;	break;
						case 839:	$fee = 5355.4;	break;
						case 840:	$fee = 5361.7;	break;
						case 841:	$fee = 5368.1;	break;
						case 842:	$fee = 5374.5;	break;
						case 843:	$fee = 5380.9;	break;
						case 844:	$fee = 5387.3;	break;
						case 845:	$fee = 5393.7;	break;
						case 846:	$fee = 5400;	break;
						case 847:	$fee = 5406.4;	break;
						case 848:	$fee = 5412.8;	break;
						case 849:	$fee = 5419.2;	break;
						case 850:	$fee = 5425.6;	break;
						case 851:	$fee = 5432;	break;
						case 852:	$fee = 5438.3;	break;
						case 853:	$fee = 5444.7;	break;
						case 854:	$fee = 5451.1;	break;
						case 855:	$fee = 5457.5;	break;
						case 856:	$fee = 5463.9;	break;
						case 857:	$fee = 5470.3;	break;
						case 858:	$fee = 5476.6;	break;
						case 859:	$fee = 5483;	break;
						case 860:	$fee = 5489.4;	break;
						case 861:	$fee = 5495.8;	break;
						case 862:	$fee = 5502.2;	break;
						case 863:	$fee = 5508.6;	break;
						case 864:	$fee = 5514.9;	break;
						case 865:	$fee = 5521.3;	break;
						case 866:	$fee = 5527.7;	break;
						case 867:	$fee = 5534.1;	break;
						case 868:	$fee = 5540.5;	break;
						case 869:	$fee = 5546.9;	break;
						case 870:	$fee = 5553.2;	break;
						case 871:	$fee = 5559.6;	break;
						case 872:	$fee = 5566;	break;
						case 873:	$fee = 5572.4;	break;
						case 874:	$fee = 5578.8;	break;
						case 875:	$fee = 5585.2;	break;
						case 876:	$fee = 5591.5;	break;
						case 877:	$fee = 5597.9;	break;
						case 878:	$fee = 5604.3;	break;
						case 879:	$fee = 5610.7;	break;
						case 880:	$fee = 5617.1;	break;
						case 881:	$fee = 5623.4;	break;
						case 882:	$fee = 5629.8;	break;
						case 883:	$fee = 5636.2;	break;
						case 884:	$fee = 5642.6;	break;
						case 885:	$fee = 5649;	break;
						case 886:	$fee = 5655.4;	break;
						case 887:	$fee = 5661.7;	break;
						case 888:	$fee = 5668.1;	break;
						case 889:	$fee = 5674.5;	break;
						case 890:	$fee = 5680.9;	break;
						case 891:	$fee = 5687.3;	break;
						case 892:	$fee = 5693.7;	break;
						case 893:	$fee = 5700;	break;
						case 894:	$fee = 5706.4;	break;
						case 895:	$fee = 5712.8;	break;
						case 896:	$fee = 5719.2;	break;
						case 897:	$fee = 5725.6;	break;
						case 898:	$fee = 5732;	break;
						case 899:	$fee = 5738.3;	break;
						case 900:	$fee = 5744.7;	break;
						case 901:	$fee = 5751.1;	break;
						case 902:	$fee = 5757.5;	break;
						case 903:	$fee = 5763.9;	break;
						case 904:	$fee = 5770.3;	break;
						case 905:	$fee = 5776.6;	break;
						case 906:	$fee = 5783;	break;
						case 907:	$fee = 5789.4;	break;
						case 908:	$fee = 5795.8;	break;
						case 909:	$fee = 5802.2;	break;
						case 910:	$fee = 5808.6;	break;
						case 911:	$fee = 5814.9;	break;
						case 912:	$fee = 5821.3;	break;
						case 913:	$fee = 5827.7;	break;
						case 914:	$fee = 5834.1;	break;
						case 915:	$fee = 5840.5;	break;
						case 916:	$fee = 5846.9;	break;
						case 917:	$fee = 5853.2;	break;
						case 918:	$fee = 5859.6;	break;
						case 919:	$fee = 5866;	break;
						case 920:	$fee = 5872.4;	break;
						case 921:	$fee = 5878.8;	break;
						case 922:	$fee = 5885.2;	break;
						case 923:	$fee = 5891.5;	break;
						case 924:	$fee = 5897.9;	break;
						case 925:	$fee = 5904.3;	break;
						case 926:	$fee = 5910.7;	break;
						case 927:	$fee = 5917.1;	break;
						case 928:	$fee = 5923.4;	break;
						case 929:	$fee = 5929.8;	break;
						case 930:	$fee = 5936.2;	break;
						case 931:	$fee = 5942.6;	break;
						case 932:	$fee = 5949;	break;
						case 933:	$fee = 5955.4;	break;
						case 934:	$fee = 5961.7;	break;
						case 935:	$fee = 5968.1;	break;
						case 936:	$fee = 5974.5;	break;
						case 937:	$fee = 5980.9;	break;
						case 938:	$fee = 5987.3;	break;
						case 939:	$fee = 5993.7;	break;
						case 940:	$fee = 6000;	break;
						case 941:	$fee = 6006.4;	break;
						case 942:	$fee = 6012.8;	break;
						case 943:	$fee = 6019.2;	break;
						case 944:	$fee = 6025.6;	break;
						case 945:	$fee = 6032;	break;
						case 946:	$fee = 6038.3;	break;
						case 947:	$fee = 6044.7;	break;
						case 948:	$fee = 6051.1;	break;
						case 949:	$fee = 6057.5;	break;
						case 950:	$fee = 6063.9;	break;
						case 951:	$fee = 6070.3;	break;
						case 952:	$fee = 6076.6;	break;
						case 953:	$fee = 6083;	break;
						case 954:	$fee = 6089.4;	break;
						case 955:	$fee = 6095.8;	break;
						case 956:	$fee = 6102.2;	break;
						case 957:	$fee = 6108.6;	break;
						case 958:	$fee = 6114.9;	break;
						case 959:	$fee = 6121.3;	break;
						case 960:	$fee = 6127.7;	break;
						case 961:	$fee = 6134.1;	break;
						case 962:	$fee = 6140.5;	break;
						case 963:	$fee = 6146.9;	break;
						case 964:	$fee = 6153.2;	break;
						case 965:	$fee = 6159.6;	break;
						case 966:	$fee = 6166;	break;
						case 967:	$fee = 6172.4;	break;
						case 968:	$fee = 6178.8;	break;
						case 969:	$fee = 6185.2;	break;
						case 970:	$fee = 6191.5;	break;
						case 971:	$fee = 6197.9;	break;
						case 972:	$fee = 6204.3;	break;
						case 973:	$fee = 6210.7;	break;
						case 974:	$fee = 6217.1;	break;
						case 975:	$fee = 6223.4;	break;
						case 976:	$fee = 6229.8;	break;
						case 977:	$fee = 6236.2;	break;
						case 978:	$fee = 6242.6;	break;
						case 979:	$fee = 6249;	break;
						case 980:	$fee = 6255.4;	break;
						case 981:	$fee = 6261.7;	break;
						case 982:	$fee = 6268.1;	break;
						case 983:	$fee = 6274.5;	break;
						case 984:	$fee = 6280.9;	break;
						case 985:	$fee = 6287.3;	break;
						case 986:	$fee = 6293.7;	break;
						case 987:	$fee = 6300;	break;
						case 988:	$fee = 6306.4;	break;
						case 989:	$fee = 6312.8;	break;
						case 990:	$fee = 6319.2;	break;
						case 991:	$fee = 6325.6;	break;
						case 992:	$fee = 6332;	break;
						case 993:	$fee = 6338.3;	break;
						case 994:	$fee = 6344.7;	break;
						case 995:	$fee = 6351.1;	break;
						case 996:	$fee = 6357.5;	break;
						case 997:	$fee = 6363.9;	break;
						case 998:	$fee = 6370.3;	break;
						case 999:	$fee = 6376.6;	break;
						case 1000:	$fee = 6383;	break;

						default:
							$fee = ceil(1.1 * $org_fee / 21);
							break;	
					}
				break;
				case 'Macau': 
					switch ($weight){
						case 1:	$fee = 8.4;	break;
						case 2:	$fee = 14.5;	break;
						case 3:	$fee = 20.9;	break;
						case 4:	$fee = 28.9;	break;
						case 5:	$fee = 37;	break;
						case 6:	$fee = 45.1;	break;
						case 7:	$fee = 53.1;	break;
						case 8:	$fee = 61.2;	break;
						case 9:	$fee = 69.3;	break;
						case 10:	$fee = 77.3;	break;
						case 11:	$fee = 85.4;	break;
						case 12:	$fee = 93.4;	break;
						case 13:	$fee = 101.5;	break;
						case 14:	$fee = 109.6;	break;
						case 15:	$fee = 117.6;	break;
						case 16:	$fee = 125.7;	break;
						case 17:	$fee = 133.8;	break;
						case 18:	$fee = 141.8;	break;
						case 19:	$fee = 149.9;	break;
						case 20:	$fee = 158.6;	break;
						case 21:	$fee = 166.5;	break;
						case 22:	$fee = 174.5;	break;
						case 23:	$fee = 182.4;	break;
						case 24:	$fee = 190.3;	break;
						case 25:	$fee = 198.3;	break;
						case 26:	$fee = 206.2;	break;
						case 27:	$fee = 214.1;	break;
						case 28:	$fee = 222;	break;
						case 29:	$fee = 230;	break;
						case 30:	$fee = 237.9;	break;
						case 31:	$fee = 245.8;	break;
						case 32:	$fee = 253.8;	break;
						case 33:	$fee = 261.7;	break;
						case 34:	$fee = 269.6;	break;
						case 35:	$fee = 277.5;	break;
						case 36:	$fee = 285.5;	break;
						case 37:	$fee = 293.4;	break;
						case 38:	$fee = 301.3;	break;
						case 39:	$fee = 309.3;	break;
						case 40:	$fee = 317.2;	break;
						case 41:	$fee = 325.1;	break;
						case 42:	$fee = 333;	break;
						case 43:	$fee = 341;	break;
						case 44:	$fee = 348.9;	break;
						case 45:	$fee = 356.8;	break;
						case 46:	$fee = 364.8;	break;
						case 47:	$fee = 372.7;	break;
						case 48:	$fee = 380.6;	break;
						case 49:	$fee = 388.5;	break;
						case 50:	$fee = 396.5;	break;
						case 51:	$fee = 404.4;	break;
						case 52:	$fee = 412.3;	break;
						case 53:	$fee = 420.3;	break;
						case 54:	$fee = 428.2;	break;
						case 55:	$fee = 436.1;	break;
						case 56:	$fee = 444;	break;
						case 57:	$fee = 452;	break;
						case 58:	$fee = 459.9;	break;
						case 59:	$fee = 467.8;	break;
						case 60:	$fee = 475.7;	break;
						case 61:	$fee = 483.7;	break;
						case 62:	$fee = 491.6;	break;
						case 63:	$fee = 499.5;	break;
						case 64:	$fee = 507.5;	break;
						case 65:	$fee = 515.4;	break;
						case 66:	$fee = 523.3;	break;
						case 67:	$fee = 531.2;	break;
						case 68:	$fee = 539.2;	break;
						case 69:	$fee = 547.1;	break;
						case 70:	$fee = 555;	break;
						case 71:	$fee = 563;	break;
						case 72:	$fee = 570.9;	break;
						case 73:	$fee = 578.8;	break;
						case 74:	$fee = 586.7;	break;
						case 75:	$fee = 594.7;	break;
						case 76:	$fee = 602.6;	break;
						case 77:	$fee = 610.5;	break;
						case 78:	$fee = 618.5;	break;
						case 79:	$fee = 626.4;	break;
						case 80:	$fee = 634.3;	break;
						case 81:	$fee = 642.2;	break;
						case 82:	$fee = 650.2;	break;
						case 83:	$fee = 658.1;	break;
						case 84:	$fee = 666;	break;
						case 85:	$fee = 674;	break;
						case 86:	$fee = 681.9;	break;
						case 87:	$fee = 689.8;	break;
						case 88:	$fee = 697.7;	break;
						case 89:	$fee = 705.7;	break;
						case 90:	$fee = 713.6;	break;
						case 91:	$fee = 721.5;	break;
						case 92:	$fee = 729.5;	break;
						case 93:	$fee = 737.4;	break;
						case 94:	$fee = 745.3;	break;
						case 95:	$fee = 753.2;	break;
						case 96:	$fee = 761.2;	break;
						case 97:	$fee = 769.1;	break;
						case 98:	$fee = 777;	break;
						case 99:	$fee = 785;	break;
						case 100:	$fee = 792.9;	break;
						case 101:	$fee = 800.8;	break;
						case 102:	$fee = 808.7;	break;
						case 103:	$fee = 816.7;	break;
						case 104:	$fee = 824.6;	break;
						case 105:	$fee = 832.5;	break;
						case 106:	$fee = 840.5;	break;
						case 107:	$fee = 848.4;	break;
						case 108:	$fee = 856.3;	break;
						case 109:	$fee = 864.2;	break;
						case 110:	$fee = 872.2;	break;
						case 111:	$fee = 880.1;	break;
						case 112:	$fee = 888;	break;
						case 113:	$fee = 896;	break;
						case 114:	$fee = 903.9;	break;
						case 115:	$fee = 911.8;	break;
						case 116:	$fee = 919.7;	break;
						case 117:	$fee = 927.7;	break;
						case 118:	$fee = 935.6;	break;
						case 119:	$fee = 943.5;	break;
						case 120:	$fee = 951.4;	break;
						case 121:	$fee = 959.4;	break;
						case 122:	$fee = 967.3;	break;
						case 123:	$fee = 975.2;	break;
						case 124:	$fee = 983.2;	break;
						case 125:	$fee = 991.1;	break;
						case 126:	$fee = 999;	break;
						case 127:	$fee = 1006.9;	break;
						case 128:	$fee = 1014.9;	break;
						case 129:	$fee = 1022.8;	break;
						case 130:	$fee = 1030.7;	break;
						case 131:	$fee = 1038.7;	break;
						case 132:	$fee = 1046.6;	break;
						case 133:	$fee = 1054.5;	break;
						case 134:	$fee = 1062.4;	break;
						case 135:	$fee = 1070.4;	break;
						case 136:	$fee = 1078.3;	break;
						case 137:	$fee = 1086.2;	break;
						case 138:	$fee = 1094.2;	break;
						case 139:	$fee = 1102.1;	break;
						case 140:	$fee = 1110;	break;
						case 141:	$fee = 1117.9;	break;
						case 142:	$fee = 1125.9;	break;
						case 143:	$fee = 1133.8;	break;
						case 144:	$fee = 1141.7;	break;
						case 145:	$fee = 1149.7;	break;
						case 146:	$fee = 1157.6;	break;
						case 147:	$fee = 1165.5;	break;
						case 148:	$fee = 1173.4;	break;
						case 149:	$fee = 1181.4;	break;
						case 150:	$fee = 1189.3;	break;
						case 151:	$fee = 1197.2;	break;
						case 152:	$fee = 1205.2;	break;
						case 153:	$fee = 1213.1;	break;
						case 154:	$fee = 1221;	break;
						case 155:	$fee = 1228.9;	break;
						case 156:	$fee = 1236.9;	break;
						case 157:	$fee = 1244.8;	break;
						case 158:	$fee = 1252.7;	break;
						case 159:	$fee = 1260.7;	break;
						case 160:	$fee = 1268.6;	break;
						case 161:	$fee = 1276.5;	break;
						case 162:	$fee = 1284.4;	break;
						case 163:	$fee = 1292.4;	break;
						case 164:	$fee = 1300.3;	break;
						case 165:	$fee = 1308.2;	break;
						case 166:	$fee = 1316.2;	break;
						case 167:	$fee = 1324.1;	break;
						case 168:	$fee = 1332;	break;
						case 169:	$fee = 1339.9;	break;
						case 170:	$fee = 1347.9;	break;
						case 171:	$fee = 1355.8;	break;
						case 172:	$fee = 1363.7;	break;
						case 173:	$fee = 1371.7;	break;
						case 174:	$fee = 1379.6;	break;
						case 175:	$fee = 1387.5;	break;
						case 176:	$fee = 1395.4;	break;
						case 177:	$fee = 1403.4;	break;
						case 178:	$fee = 1411.3;	break;
						case 179:	$fee = 1419.2;	break;
						case 180:	$fee = 1427.1;	break;
						case 181:	$fee = 1435.1;	break;
						case 182:	$fee = 1443;	break;
						case 183:	$fee = 1450.9;	break;
						case 184:	$fee = 1458.9;	break;
						case 185:	$fee = 1466.8;	break;
						case 186:	$fee = 1474.7;	break;
						case 187:	$fee = 1482.6;	break;
						case 188:	$fee = 1490.6;	break;
						case 189:	$fee = 1498.5;	break;
						case 190:	$fee = 1506.4;	break;
						case 191:	$fee = 1514.4;	break;
						case 192:	$fee = 1522.3;	break;
						case 193:	$fee = 1530.2;	break;
						case 194:	$fee = 1538.1;	break;
						case 195:	$fee = 1546.1;	break;
						case 196:	$fee = 1554;	break;
						case 197:	$fee = 1561.9;	break;
						case 198:	$fee = 1569.9;	break;
						case 199:	$fee = 1577.8;	break;
						case 200:	$fee = 1585.7;	break;
						case 201:	$fee = 1593.6;	break;
						case 202:	$fee = 1601.6;	break;
						case 203:	$fee = 1609.5;	break;
						case 204:	$fee = 1617.4;	break;
						case 205:	$fee = 1625.4;	break;
						case 206:	$fee = 1633.3;	break;
						case 207:	$fee = 1641.2;	break;
						case 208:	$fee = 1649.1;	break;
						case 209:	$fee = 1657.1;	break;
						case 210:	$fee = 1665;	break;
						case 211:	$fee = 1672.9;	break;
						case 212:	$fee = 1680.9;	break;
						case 213:	$fee = 1688.8;	break;
						case 214:	$fee = 1696.7;	break;
						case 215:	$fee = 1704.6;	break;
						case 216:	$fee = 1712.6;	break;
						case 217:	$fee = 1720.5;	break;
						case 218:	$fee = 1728.4;	break;
						case 219:	$fee = 1736.4;	break;
						case 220:	$fee = 1744.3;	break;
						case 221:	$fee = 1752.2;	break;
						case 222:	$fee = 1760.1;	break;
						case 223:	$fee = 1768.1;	break;
						case 224:	$fee = 1776;	break;
						case 225:	$fee = 1783.9;	break;
						case 226:	$fee = 1791.9;	break;
						case 227:	$fee = 1799.8;	break;
						case 228:	$fee = 1807.7;	break;
						case 229:	$fee = 1815.6;	break;
						case 230:	$fee = 1823.6;	break;
						case 231:	$fee = 1831.5;	break;
						case 232:	$fee = 1839.4;	break;
						case 233:	$fee = 1847.3;	break;
						case 234:	$fee = 1855.3;	break;
						case 235:	$fee = 1863.2;	break;
						case 236:	$fee = 1871.1;	break;
						case 237:	$fee = 1879.1;	break;
						case 238:	$fee = 1887;	break;
						case 239:	$fee = 1894.9;	break;
						case 240:	$fee = 1902.8;	break;
						case 241:	$fee = 1910.8;	break;
						case 242:	$fee = 1918.7;	break;
						case 243:	$fee = 1926.6;	break;
						case 244:	$fee = 1934.6;	break;
						case 245:	$fee = 1942.5;	break;
						case 246:	$fee = 1950.4;	break;
						case 247:	$fee = 1958.3;	break;
						case 248:	$fee = 1966.3;	break;
						case 249:	$fee = 1974.2;	break;
						case 250:	$fee = 1982.1;	break;
						case 251:	$fee = 1990.1;	break;
						case 252:	$fee = 1998;	break;
						case 253:	$fee = 2005.9;	break;
						case 254:	$fee = 2013.8;	break;
						case 255:	$fee = 2021.8;	break;
						case 256:	$fee = 2029.7;	break;
						case 257:	$fee = 2037.6;	break;
						case 258:	$fee = 2045.6;	break;
						case 259:	$fee = 2053.5;	break;
						case 260:	$fee = 2061.4;	break;
						case 261:	$fee = 2069.3;	break;
						case 262:	$fee = 2077.3;	break;
						case 263:	$fee = 2085.2;	break;
						case 264:	$fee = 2093.1;	break;
						case 265:	$fee = 2101.1;	break;
						case 266:	$fee = 2109;	break;
						case 267:	$fee = 2116.9;	break;
						case 268:	$fee = 2124.8;	break;
						case 269:	$fee = 2132.8;	break;
						case 270:	$fee = 2140.7;	break;
						case 271:	$fee = 2148.6;	break;
						case 272:	$fee = 2156.6;	break;
						case 273:	$fee = 2164.5;	break;
						case 274:	$fee = 2172.4;	break;
						case 275:	$fee = 2180.3;	break;
						case 276:	$fee = 2188.3;	break;
						case 277:	$fee = 2196.2;	break;
						case 278:	$fee = 2204.1;	break;
						case 279:	$fee = 2212.1;	break;
						case 280:	$fee = 2220;	break;
						case 281:	$fee = 2227.9;	break;
						case 282:	$fee = 2235.8;	break;
						case 283:	$fee = 2243.8;	break;
						case 284:	$fee = 2251.7;	break;
						case 285:	$fee = 2259.6;	break;
						case 286:	$fee = 2267.6;	break;
						case 287:	$fee = 2275.5;	break;
						case 288:	$fee = 2283.4;	break;
						case 289:	$fee = 2291.3;	break;
						case 290:	$fee = 2299.3;	break;
						case 291:	$fee = 2307.2;	break;
						case 292:	$fee = 2315.1;	break;
						case 293:	$fee = 2323;	break;
						case 294:	$fee = 2331;	break;
						case 295:	$fee = 2338.9;	break;
						case 296:	$fee = 2346.8;	break;
						case 297:	$fee = 2354.8;	break;
						case 298:	$fee = 2362.7;	break;
						case 299:	$fee = 2370.6;	break;
						case 300:	$fee = 2378.5;	break;
						case 301:	$fee = 2386.5;	break;
						case 302:	$fee = 2394.4;	break;
						case 303:	$fee = 2402.3;	break;
						case 304:	$fee = 2410.3;	break;
						case 305:	$fee = 2418.2;	break;
						case 306:	$fee = 2426.1;	break;
						case 307:	$fee = 2434;	break;
						case 308:	$fee = 2442;	break;
						case 309:	$fee = 2449.9;	break;
						case 310:	$fee = 2457.8;	break;
						case 311:	$fee = 2465.8;	break;
						case 312:	$fee = 2473.7;	break;
						case 313:	$fee = 2481.6;	break;
						case 314:	$fee = 2489.5;	break;
						case 315:	$fee = 2497.5;	break;
						case 316:	$fee = 2505.4;	break;
						case 317:	$fee = 2513.3;	break;
						case 318:	$fee = 2521.3;	break;
						case 319:	$fee = 2529.2;	break;
						case 320:	$fee = 2537.1;	break;
						case 321:	$fee = 2545;	break;
						case 322:	$fee = 2553;	break;
						case 323:	$fee = 2560.9;	break;
						case 324:	$fee = 2568.8;	break;
						case 325:	$fee = 2576.8;	break;
						case 326:	$fee = 2584.7;	break;
						case 327:	$fee = 2592.6;	break;
						case 328:	$fee = 2600.5;	break;
						case 329:	$fee = 2608.5;	break;
						case 330:	$fee = 2616.4;	break;
						case 331:	$fee = 2624.3;	break;
						case 332:	$fee = 2632.3;	break;
						case 333:	$fee = 2640.2;	break;
						case 334:	$fee = 2648.1;	break;
						case 335:	$fee = 2656;	break;
						case 336:	$fee = 2664;	break;
						case 337:	$fee = 2671.9;	break;
						case 338:	$fee = 2679.8;	break;
						case 339:	$fee = 2687.8;	break;
						case 340:	$fee = 2695.7;	break;
						case 341:	$fee = 2703.6;	break;
						case 342:	$fee = 2711.5;	break;
						case 343:	$fee = 2719.5;	break;
						case 344:	$fee = 2727.4;	break;
						case 345:	$fee = 2735.3;	break;
						case 346:	$fee = 2743.3;	break;
						case 347:	$fee = 2751.2;	break;
						case 348:	$fee = 2759.1;	break;
						case 349:	$fee = 2767;	break;
						case 350:	$fee = 2775;	break;
						case 351:	$fee = 2782.9;	break;
						case 352:	$fee = 2790.8;	break;
						case 353:	$fee = 2798.7;	break;
						case 354:	$fee = 2806.7;	break;
						case 355:	$fee = 2814.6;	break;
						case 356:	$fee = 2822.5;	break;
						case 357:	$fee = 2830.5;	break;
						case 358:	$fee = 2838.4;	break;
						case 359:	$fee = 2846.3;	break;
						case 360:	$fee = 2854.2;	break;
						case 361:	$fee = 2862.2;	break;
						case 362:	$fee = 2870.1;	break;
						case 363:	$fee = 2878;	break;
						case 364:	$fee = 2886;	break;
						case 365:	$fee = 2893.9;	break;
						case 366:	$fee = 2901.8;	break;
						case 367:	$fee = 2909.7;	break;
						case 368:	$fee = 2917.7;	break;
						case 369:	$fee = 2925.6;	break;
						case 370:	$fee = 2933.5;	break;
						case 371:	$fee = 2941.5;	break;
						case 372:	$fee = 2949.4;	break;
						case 373:	$fee = 2957.3;	break;
						case 374:	$fee = 2965.2;	break;
						case 375:	$fee = 2973.2;	break;
						case 376:	$fee = 2981.1;	break;
						case 377:	$fee = 2989;	break;
						case 378:	$fee = 2997;	break;
						case 379:	$fee = 3004.9;	break;
						case 380:	$fee = 3012.8;	break;
						case 381:	$fee = 3020.7;	break;
						case 382:	$fee = 3028.7;	break;
						case 383:	$fee = 3036.6;	break;
						case 384:	$fee = 3044.5;	break;
						case 385:	$fee = 3052.5;	break;
						case 386:	$fee = 3060.4;	break;
						case 387:	$fee = 3068.3;	break;
						case 388:	$fee = 3076.2;	break;
						case 389:	$fee = 3084.2;	break;
						case 390:	$fee = 3092.1;	break;
						case 391:	$fee = 3100;	break;
						case 392:	$fee = 3108;	break;
						case 393:	$fee = 3115.9;	break;
						case 394:	$fee = 3123.8;	break;
						case 395:	$fee = 3131.7;	break;
						case 396:	$fee = 3139.7;	break;
						case 397:	$fee = 3147.6;	break;
						case 398:	$fee = 3155.5;	break;
						case 399:	$fee = 3163.5;	break;
						case 400:	$fee = 3171.4;	break;
						case 401:	$fee = 3179.3;	break;
						case 402:	$fee = 3187.2;	break;
						case 403:	$fee = 3195.2;	break;
						case 404:	$fee = 3203.1;	break;
						case 405:	$fee = 3211;	break;
						case 406:	$fee = 3218.9;	break;
						case 407:	$fee = 3226.9;	break;
						case 408:	$fee = 3234.8;	break;
						case 409:	$fee = 3242.7;	break;
						case 410:	$fee = 3250.7;	break;
						case 411:	$fee = 3258.6;	break;
						case 412:	$fee = 3266.5;	break;
						case 413:	$fee = 3274.4;	break;
						case 414:	$fee = 3282.4;	break;
						case 415:	$fee = 3290.3;	break;
						case 416:	$fee = 3298.2;	break;
						case 417:	$fee = 3306.2;	break;
						case 418:	$fee = 3314.1;	break;
						case 419:	$fee = 3322;	break;
						case 420:	$fee = 3329.9;	break;
						case 421:	$fee = 3337.9;	break;
						case 422:	$fee = 3345.8;	break;
						case 423:	$fee = 3353.7;	break;
						case 424:	$fee = 3361.7;	break;
						case 425:	$fee = 3369.6;	break;
						case 426:	$fee = 3377.5;	break;
						case 427:	$fee = 3385.4;	break;
						case 428:	$fee = 3393.4;	break;
						case 429:	$fee = 3401.3;	break;
						case 430:	$fee = 3409.2;	break;
						case 431:	$fee = 3417.2;	break;
						case 432:	$fee = 3425.1;	break;
						case 433:	$fee = 3433;	break;
						case 434:	$fee = 3440.9;	break;
						case 435:	$fee = 3448.9;	break;
						case 436:	$fee = 3456.8;	break;
						case 437:	$fee = 3464.7;	break;
						case 438:	$fee = 3472.7;	break;
						case 439:	$fee = 3480.6;	break;
						case 440:	$fee = 3488.5;	break;
						case 441:	$fee = 3496.4;	break;
						case 442:	$fee = 3504.4;	break;
						case 443:	$fee = 3512.3;	break;
						case 444:	$fee = 3520.2;	break;
						case 445:	$fee = 3528.2;	break;
						case 446:	$fee = 3536.1;	break;
						case 447:	$fee = 3544;	break;
						case 448:	$fee = 3551.9;	break;
						case 449:	$fee = 3559.9;	break;
						case 450:	$fee = 3567.8;	break;
						case 451:	$fee = 3575.7;	break;
						case 452:	$fee = 3583.7;	break;
						case 453:	$fee = 3591.6;	break;
						case 454:	$fee = 3599.5;	break;
						case 455:	$fee = 3607.4;	break;
						case 456:	$fee = 3615.4;	break;
						case 457:	$fee = 3623.3;	break;
						case 458:	$fee = 3631.2;	break;
						case 459:	$fee = 3639.2;	break;
						case 460:	$fee = 3647.1;	break;
						case 461:	$fee = 3655;	break;
						case 462:	$fee = 3662.9;	break;
						case 463:	$fee = 3670.9;	break;
						case 464:	$fee = 3678.8;	break;
						case 465:	$fee = 3686.7;	break;
						case 466:	$fee = 3694.6;	break;
						case 467:	$fee = 3702.6;	break;
						case 468:	$fee = 3710.5;	break;
						case 469:	$fee = 3718.4;	break;
						case 470:	$fee = 3726.4;	break;
						case 471:	$fee = 3734.3;	break;
						case 472:	$fee = 3742.2;	break;
						case 473:	$fee = 3750.1;	break;
						case 474:	$fee = 3758.1;	break;
						case 475:	$fee = 3766;	break;
						case 476:	$fee = 3773.9;	break;
						case 477:	$fee = 3781.9;	break;
						case 478:	$fee = 3789.8;	break;
						case 479:	$fee = 3797.7;	break;
						case 480:	$fee = 3805.6;	break;
						case 481:	$fee = 3813.6;	break;
						case 482:	$fee = 3821.5;	break;
						case 483:	$fee = 3829.4;	break;
						case 484:	$fee = 3837.4;	break;
						case 485:	$fee = 3845.3;	break;
						case 486:	$fee = 3853.2;	break;
						case 487:	$fee = 3861.1;	break;
						case 488:	$fee = 3869.1;	break;
						case 489:	$fee = 3877;	break;
						case 490:	$fee = 3884.9;	break;
						case 491:	$fee = 3892.9;	break;
						case 492:	$fee = 3900.8;	break;
						case 493:	$fee = 3908.7;	break;
						case 494:	$fee = 3916.6;	break;
						case 495:	$fee = 3924.6;	break;
						case 496:	$fee = 3932.5;	break;
						case 497:	$fee = 3940.4;	break;
						case 498:	$fee = 3948.4;	break;
						case 499:	$fee = 3956.3;	break;
						case 500:	$fee = 3964.2;	break;
						case 501:	$fee = 3972.1;	break;
						case 502:	$fee = 3980.1;	break;
						case 503:	$fee = 3988;	break;
						case 504:	$fee = 3995.9;	break;
						case 505:	$fee = 4003.9;	break;
						case 506:	$fee = 4011.8;	break;
						case 507:	$fee = 4019.7;	break;
						case 508:	$fee = 4027.6;	break;
						case 509:	$fee = 4035.6;	break;
						case 510:	$fee = 4043.5;	break;
						case 511:	$fee = 4051.4;	break;
						case 512:	$fee = 4059.4;	break;
						case 513:	$fee = 4067.3;	break;
						case 514:	$fee = 4075.2;	break;
						case 515:	$fee = 4083.1;	break;
						case 516:	$fee = 4091.1;	break;
						case 517:	$fee = 4099;	break;
						case 518:	$fee = 4106.9;	break;
						case 519:	$fee = 4114.9;	break;
						case 520:	$fee = 4122.8;	break;
						case 521:	$fee = 4130.7;	break;
						case 522:	$fee = 4138.6;	break;
						case 523:	$fee = 4146.6;	break;
						case 524:	$fee = 4154.5;	break;
						case 525:	$fee = 4162.4;	break;
						case 526:	$fee = 4170.3;	break;
						case 527:	$fee = 4178.3;	break;
						case 528:	$fee = 4186.2;	break;
						case 529:	$fee = 4194.1;	break;
						case 530:	$fee = 4202.1;	break;
						case 531:	$fee = 4210;	break;
						case 532:	$fee = 4217.9;	break;
						case 533:	$fee = 4225.8;	break;
						case 534:	$fee = 4233.8;	break;
						case 535:	$fee = 4241.7;	break;
						case 536:	$fee = 4249.6;	break;
						case 537:	$fee = 4257.6;	break;
						case 538:	$fee = 4265.5;	break;
						case 539:	$fee = 4273.4;	break;
						case 540:	$fee = 4281.3;	break;
						case 541:	$fee = 4289.3;	break;
						case 542:	$fee = 4297.2;	break;
						case 543:	$fee = 4305.1;	break;
						case 544:	$fee = 4313.1;	break;
						case 545:	$fee = 4321;	break;
						case 546:	$fee = 4328.9;	break;
						case 547:	$fee = 4336.8;	break;
						case 548:	$fee = 4344.8;	break;
						case 549:	$fee = 4352.7;	break;
						case 550:	$fee = 4360.6;	break;
						case 551:	$fee = 4368.6;	break;
						case 552:	$fee = 4376.5;	break;
						case 553:	$fee = 4384.4;	break;
						case 554:	$fee = 4392.3;	break;
						case 555:	$fee = 4400.3;	break;
						case 556:	$fee = 4408.2;	break;
						case 557:	$fee = 4416.1;	break;
						case 558:	$fee = 4424.1;	break;
						case 559:	$fee = 4432;	break;
						case 560:	$fee = 4439.9;	break;
						case 561:	$fee = 4447.8;	break;
						case 562:	$fee = 4455.8;	break;
						case 563:	$fee = 4463.7;	break;
						case 564:	$fee = 4471.6;	break;
						case 565:	$fee = 4479.6;	break;
						case 566:	$fee = 4487.5;	break;
						case 567:	$fee = 4495.4;	break;
						case 568:	$fee = 4503.3;	break;
						case 569:	$fee = 4511.3;	break;
						case 570:	$fee = 4519.2;	break;
						case 571:	$fee = 4527.1;	break;
						case 572:	$fee = 4535.1;	break;
						case 573:	$fee = 4543;	break;
						case 574:	$fee = 4550.9;	break;
						case 575:	$fee = 4558.8;	break;
						case 576:	$fee = 4566.8;	break;
						case 577:	$fee = 4574.7;	break;
						case 578:	$fee = 4582.6;	break;
						case 579:	$fee = 4590.5;	break;
						case 580:	$fee = 4598.5;	break;
						case 581:	$fee = 4606.4;	break;
						case 582:	$fee = 4614.3;	break;
						case 583:	$fee = 4622.3;	break;
						case 584:	$fee = 4630.2;	break;
						case 585:	$fee = 4638.1;	break;
						case 586:	$fee = 4646;	break;
						case 587:	$fee = 4654;	break;
						case 588:	$fee = 4661.9;	break;
						case 589:	$fee = 4669.8;	break;
						case 590:	$fee = 4677.8;	break;
						case 591:	$fee = 4685.7;	break;
						case 592:	$fee = 4693.6;	break;
						case 593:	$fee = 4701.5;	break;
						case 594:	$fee = 4709.5;	break;
						case 595:	$fee = 4717.4;	break;
						case 596:	$fee = 4725.3;	break;
						case 597:	$fee = 4733.3;	break;
						case 598:	$fee = 4741.2;	break;
						case 599:	$fee = 4749.1;	break;
						case 600:	$fee = 4757;	break;
						case 601:	$fee = 4765;	break;
						case 602:	$fee = 4772.9;	break;
						case 603:	$fee = 4780.8;	break;
						case 604:	$fee = 4788.8;	break;
						case 605:	$fee = 4796.7;	break;
						case 606:	$fee = 4804.6;	break;
						case 607:	$fee = 4812.5;	break;
						case 608:	$fee = 4820.5;	break;
						case 609:	$fee = 4828.4;	break;
						case 610:	$fee = 4836.3;	break;
						case 611:	$fee = 4844.3;	break;
						case 612:	$fee = 4852.2;	break;
						case 613:	$fee = 4860.1;	break;
						case 614:	$fee = 4868;	break;
						case 615:	$fee = 4876;	break;
						case 616:	$fee = 4883.9;	break;
						case 617:	$fee = 4891.8;	break;
						case 618:	$fee = 4899.8;	break;
						case 619:	$fee = 4907.7;	break;
						case 620:	$fee = 4915.6;	break;
						case 621:	$fee = 4923.5;	break;
						case 622:	$fee = 4931.5;	break;
						case 623:	$fee = 4939.4;	break;
						case 624:	$fee = 4947.3;	break;
						case 625:	$fee = 4955.3;	break;
						case 626:	$fee = 4963.2;	break;
						case 627:	$fee = 4971.1;	break;
						case 628:	$fee = 4979;	break;
						case 629:	$fee = 4987;	break;
						case 630:	$fee = 4994.9;	break;
						case 631:	$fee = 5002.8;	break;
						case 632:	$fee = 5010.8;	break;
						case 633:	$fee = 5018.7;	break;
						case 634:	$fee = 5026.6;	break;
						case 635:	$fee = 5034.5;	break;
						case 636:	$fee = 5042.5;	break;
						case 637:	$fee = 5050.4;	break;
						case 638:	$fee = 5058.3;	break;
						case 639:	$fee = 5066.2;	break;
						case 640:	$fee = 5074.2;	break;
						case 641:	$fee = 5082.1;	break;
						case 642:	$fee = 5090;	break;
						case 643:	$fee = 5098;	break;
						case 644:	$fee = 5105.9;	break;
						case 645:	$fee = 5113.8;	break;
						case 646:	$fee = 5121.7;	break;
						case 647:	$fee = 5129.7;	break;
						case 648:	$fee = 5137.6;	break;
						case 649:	$fee = 5145.5;	break;
						case 650:	$fee = 5153.5;	break;
						case 651:	$fee = 5161.4;	break;
						case 652:	$fee = 5169.3;	break;
						case 653:	$fee = 5177.2;	break;
						case 654:	$fee = 5185.2;	break;
						case 655:	$fee = 5193.1;	break;
						case 656:	$fee = 5201;	break;
						case 657:	$fee = 5209;	break;
						case 658:	$fee = 5216.9;	break;
						case 659:	$fee = 5224.8;	break;
						case 660:	$fee = 5232.7;	break;
						case 661:	$fee = 5240.7;	break;
						case 662:	$fee = 5248.6;	break;
						case 663:	$fee = 5256.5;	break;
						case 664:	$fee = 5264.5;	break;
						case 665:	$fee = 5272.4;	break;
						case 666:	$fee = 5280.3;	break;
						case 667:	$fee = 5288.2;	break;
						case 668:	$fee = 5296.2;	break;
						case 669:	$fee = 5304.1;	break;
						case 670:	$fee = 5312;	break;
						case 671:	$fee = 5320;	break;
						case 672:	$fee = 5327.9;	break;
						case 673:	$fee = 5335.8;	break;
						case 674:	$fee = 5343.7;	break;
						case 675:	$fee = 5351.7;	break;
						case 676:	$fee = 5359.6;	break;
						case 677:	$fee = 5367.5;	break;
						case 678:	$fee = 5375.5;	break;
						case 679:	$fee = 5383.4;	break;
						case 680:	$fee = 5391.3;	break;
						case 681:	$fee = 5399.2;	break;
						case 682:	$fee = 5407.2;	break;
						case 683:	$fee = 5415.1;	break;
						case 684:	$fee = 5423;	break;
						case 685:	$fee = 5431;	break;
						case 686:	$fee = 5438.9;	break;
						case 687:	$fee = 5446.8;	break;
						case 688:	$fee = 5454.7;	break;
						case 689:	$fee = 5462.7;	break;
						case 690:	$fee = 5470.6;	break;
						case 691:	$fee = 5478.5;	break;
						case 692:	$fee = 5486.5;	break;
						case 693:	$fee = 5494.4;	break;
						case 694:	$fee = 5502.3;	break;
						case 695:	$fee = 5510.2;	break;
						case 696:	$fee = 5518.2;	break;
						case 697:	$fee = 5526.1;	break;
						case 698:	$fee = 5534;	break;
						case 699:	$fee = 5541.9;	break;
						case 700:	$fee = 5549.9;	break;
						case 701:	$fee = 5557.8;	break;
						case 702:	$fee = 5565.7;	break;
						case 703:	$fee = 5573.7;	break;
						case 704:	$fee = 5581.6;	break;
						case 705:	$fee = 5589.5;	break;
						case 706:	$fee = 5597.4;	break;
						case 707:	$fee = 5605.4;	break;
						case 708:	$fee = 5613.3;	break;
						case 709:	$fee = 5621.2;	break;
						case 710:	$fee = 5629.2;	break;
						case 711:	$fee = 5637.1;	break;
						case 712:	$fee = 5645;	break;
						case 713:	$fee = 5652.9;	break;
						case 714:	$fee = 5660.9;	break;
						case 715:	$fee = 5668.8;	break;
						case 716:	$fee = 5676.7;	break;
						case 717:	$fee = 5684.7;	break;
						case 718:	$fee = 5692.6;	break;
						case 719:	$fee = 5700.5;	break;
						case 720:	$fee = 5708.4;	break;
						case 721:	$fee = 5716.4;	break;
						case 722:	$fee = 5724.3;	break;
						case 723:	$fee = 5732.2;	break;
						case 724:	$fee = 5740.2;	break;
						case 725:	$fee = 5748.1;	break;
						case 726:	$fee = 5756;	break;
						case 727:	$fee = 5763.9;	break;
						case 728:	$fee = 5771.9;	break;
						case 729:	$fee = 5779.8;	break;
						case 730:	$fee = 5787.7;	break;
						case 731:	$fee = 5795.7;	break;
						case 732:	$fee = 5803.6;	break;
						case 733:	$fee = 5811.5;	break;
						case 734:	$fee = 5819.4;	break;
						case 735:	$fee = 5827.4;	break;
						case 736:	$fee = 5835.3;	break;
						case 737:	$fee = 5843.2;	break;
						case 738:	$fee = 5851.2;	break;
						case 739:	$fee = 5859.1;	break;
						case 740:	$fee = 5867;	break;
						case 741:	$fee = 5874.9;	break;
						case 742:	$fee = 5882.9;	break;
						case 743:	$fee = 5890.8;	break;
						case 744:	$fee = 5898.7;	break;
						case 745:	$fee = 5906.7;	break;
						case 746:	$fee = 5914.6;	break;
						case 747:	$fee = 5922.5;	break;
						case 748:	$fee = 5930.4;	break;
						case 749:	$fee = 5938.4;	break;
						case 750:	$fee = 5946.3;	break;
						case 751:	$fee = 5954.2;	break;
						case 752:	$fee = 5962.1;	break;
						case 753:	$fee = 5970.1;	break;
						case 754:	$fee = 5978;	break;
						case 755:	$fee = 5985.9;	break;
						case 756:	$fee = 5993.9;	break;
						case 757:	$fee = 6001.8;	break;
						case 758:	$fee = 6009.7;	break;
						case 759:	$fee = 6017.6;	break;
						case 760:	$fee = 6025.6;	break;
						case 761:	$fee = 6033.5;	break;
						case 762:	$fee = 6041.4;	break;
						case 763:	$fee = 6049.4;	break;
						case 764:	$fee = 6057.3;	break;
						case 765:	$fee = 6065.2;	break;
						case 766:	$fee = 6073.1;	break;
						case 767:	$fee = 6081.1;	break;
						case 768:	$fee = 6089;	break;
						case 769:	$fee = 6096.9;	break;
						case 770:	$fee = 6104.9;	break;
						case 771:	$fee = 6112.8;	break;
						case 772:	$fee = 6120.7;	break;
						case 773:	$fee = 6128.6;	break;
						case 774:	$fee = 6136.6;	break;
						case 775:	$fee = 6144.5;	break;
						case 776:	$fee = 6152.4;	break;
						case 777:	$fee = 6160.4;	break;
						case 778:	$fee = 6168.3;	break;
						case 779:	$fee = 6176.2;	break;
						case 780:	$fee = 6184.1;	break;
						case 781:	$fee = 6192.1;	break;
						case 782:	$fee = 6200;	break;
						case 783:	$fee = 6207.9;	break;
						case 784:	$fee = 6215.9;	break;
						case 785:	$fee = 6223.8;	break;
						case 786:	$fee = 6231.7;	break;
						case 787:	$fee = 6239.6;	break;
						case 788:	$fee = 6247.6;	break;
						case 789:	$fee = 6255.5;	break;
						case 790:	$fee = 6263.4;	break;
						case 791:	$fee = 6271.4;	break;
						case 792:	$fee = 6279.3;	break;
						case 793:	$fee = 6287.2;	break;
						case 794:	$fee = 6295.1;	break;
						case 795:	$fee = 6303.1;	break;
						case 796:	$fee = 6311;	break;
						case 797:	$fee = 6318.9;	break;
						case 798:	$fee = 6326.9;	break;
						case 799:	$fee = 6334.8;	break;
						case 800:	$fee = 6342.7;	break;
						case 801:	$fee = 6350.6;	break;
						case 802:	$fee = 6358.6;	break;
						case 803:	$fee = 6366.5;	break;
						case 804:	$fee = 6374.4;	break;
						case 805:	$fee = 6382.4;	break;
						case 806:	$fee = 6390.3;	break;
						case 807:	$fee = 6398.2;	break;
						case 808:	$fee = 6406.1;	break;
						case 809:	$fee = 6414.1;	break;
						case 810:	$fee = 6422;	break;
						case 811:	$fee = 6429.9;	break;
						case 812:	$fee = 6437.8;	break;
						case 813:	$fee = 6445.8;	break;
						case 814:	$fee = 6453.7;	break;
						case 815:	$fee = 6461.6;	break;
						case 816:	$fee = 6469.6;	break;
						case 817:	$fee = 6477.5;	break;
						case 818:	$fee = 6485.4;	break;
						case 819:	$fee = 6493.3;	break;
						case 820:	$fee = 6501.3;	break;
						case 821:	$fee = 6509.2;	break;
						case 822:	$fee = 6517.1;	break;
						case 823:	$fee = 6525.1;	break;
						case 824:	$fee = 6533;	break;
						case 825:	$fee = 6540.9;	break;
						case 826:	$fee = 6548.8;	break;
						case 827:	$fee = 6556.8;	break;
						case 828:	$fee = 6564.7;	break;
						case 829:	$fee = 6572.6;	break;
						case 830:	$fee = 6580.6;	break;
						case 831:	$fee = 6588.5;	break;
						case 832:	$fee = 6596.4;	break;
						case 833:	$fee = 6604.3;	break;
						case 834:	$fee = 6612.3;	break;
						case 835:	$fee = 6620.2;	break;
						case 836:	$fee = 6628.1;	break;
						case 837:	$fee = 6636.1;	break;
						case 838:	$fee = 6644;	break;
						case 839:	$fee = 6651.9;	break;
						case 840:	$fee = 6659.8;	break;
						case 841:	$fee = 6667.8;	break;
						case 842:	$fee = 6675.7;	break;
						case 843:	$fee = 6683.6;	break;
						case 844:	$fee = 6691.6;	break;
						case 845:	$fee = 6699.5;	break;
						case 846:	$fee = 6707.4;	break;
						case 847:	$fee = 6715.3;	break;
						case 848:	$fee = 6723.3;	break;
						case 849:	$fee = 6731.2;	break;
						case 850:	$fee = 6739.1;	break;
						case 851:	$fee = 6747.1;	break;
						case 852:	$fee = 6755;	break;
						case 853:	$fee = 6762.9;	break;
						case 854:	$fee = 6770.8;	break;
						case 855:	$fee = 6778.8;	break;
						case 856:	$fee = 6786.7;	break;
						case 857:	$fee = 6794.6;	break;
						case 858:	$fee = 6802.6;	break;
						case 859:	$fee = 6810.5;	break;
						case 860:	$fee = 6818.4;	break;
						case 861:	$fee = 6826.3;	break;
						case 862:	$fee = 6834.3;	break;
						case 863:	$fee = 6842.2;	break;
						case 864:	$fee = 6850.1;	break;
						case 865:	$fee = 6858.1;	break;
						case 866:	$fee = 6866;	break;
						case 867:	$fee = 6873.9;	break;
						case 868:	$fee = 6881.8;	break;
						case 869:	$fee = 6889.8;	break;
						case 870:	$fee = 6897.7;	break;
						case 871:	$fee = 6905.6;	break;
						case 872:	$fee = 6913.5;	break;
						case 873:	$fee = 6921.5;	break;
						case 874:	$fee = 6929.4;	break;
						case 875:	$fee = 6937.3;	break;
						case 876:	$fee = 6945.3;	break;
						case 877:	$fee = 6953.2;	break;
						case 878:	$fee = 6961.1;	break;
						case 879:	$fee = 6969;	break;
						case 880:	$fee = 6977;	break;
						case 881:	$fee = 6984.9;	break;
						case 882:	$fee = 6992.8;	break;
						case 883:	$fee = 7000.8;	break;
						case 884:	$fee = 7008.7;	break;
						case 885:	$fee = 7016.6;	break;
						case 886:	$fee = 7024.5;	break;
						case 887:	$fee = 7032.5;	break;
						case 888:	$fee = 7040.4;	break;
						case 889:	$fee = 7048.3;	break;
						case 890:	$fee = 7056.3;	break;
						case 891:	$fee = 7064.2;	break;
						case 892:	$fee = 7072.1;	break;
						case 893:	$fee = 7080;	break;
						case 894:	$fee = 7088;	break;
						case 895:	$fee = 7095.9;	break;
						case 896:	$fee = 7103.8;	break;
						case 897:	$fee = 7111.8;	break;
						case 898:	$fee = 7119.7;	break;
						case 899:	$fee = 7127.6;	break;
						case 900:	$fee = 7135.5;	break;
						case 901:	$fee = 7143.5;	break;
						case 902:	$fee = 7151.4;	break;
						case 903:	$fee = 7159.3;	break;
						case 904:	$fee = 7167.3;	break;
						case 905:	$fee = 7175.2;	break;
						case 906:	$fee = 7183.1;	break;
						case 907:	$fee = 7191;	break;
						case 908:	$fee = 7199;	break;
						case 909:	$fee = 7206.9;	break;
						case 910:	$fee = 7214.8;	break;
						case 911:	$fee = 7222.8;	break;
						case 912:	$fee = 7230.7;	break;
						case 913:	$fee = 7238.6;	break;
						case 914:	$fee = 7246.5;	break;
						case 915:	$fee = 7254.5;	break;
						case 916:	$fee = 7262.4;	break;
						case 917:	$fee = 7270.3;	break;
						case 918:	$fee = 7278.3;	break;
						case 919:	$fee = 7286.2;	break;
						case 920:	$fee = 7294.1;	break;
						case 921:	$fee = 7302;	break;
						case 922:	$fee = 7310;	break;
						case 923:	$fee = 7317.9;	break;
						case 924:	$fee = 7325.8;	break;
						case 925:	$fee = 7333.7;	break;
						case 926:	$fee = 7341.7;	break;
						case 927:	$fee = 7349.6;	break;
						case 928:	$fee = 7357.5;	break;
						case 929:	$fee = 7365.5;	break;
						case 930:	$fee = 7373.4;	break;
						case 931:	$fee = 7381.3;	break;
						case 932:	$fee = 7389.2;	break;
						case 933:	$fee = 7397.2;	break;
						case 934:	$fee = 7405.1;	break;
						case 935:	$fee = 7413;	break;
						case 936:	$fee = 7421;	break;
						case 937:	$fee = 7428.9;	break;
						case 938:	$fee = 7436.8;	break;
						case 939:	$fee = 7444.7;	break;
						case 940:	$fee = 7452.7;	break;
						case 941:	$fee = 7460.6;	break;
						case 942:	$fee = 7468.5;	break;
						case 943:	$fee = 7476.5;	break;
						case 944:	$fee = 7484.4;	break;
						case 945:	$fee = 7492.3;	break;
						case 946:	$fee = 7500.2;	break;
						case 947:	$fee = 7508.2;	break;
						case 948:	$fee = 7516.1;	break;
						case 949:	$fee = 7524;	break;
						case 950:	$fee = 7532;	break;
						case 951:	$fee = 7539.9;	break;
						case 952:	$fee = 7547.8;	break;
						case 953:	$fee = 7555.7;	break;
						case 954:	$fee = 7563.7;	break;
						case 955:	$fee = 7571.6;	break;
						case 956:	$fee = 7579.5;	break;
						case 957:	$fee = 7587.5;	break;
						case 958:	$fee = 7595.4;	break;
						case 959:	$fee = 7603.3;	break;
						case 960:	$fee = 7611.2;	break;
						case 961:	$fee = 7619.2;	break;
						case 962:	$fee = 7627.1;	break;
						case 963:	$fee = 7635;	break;
						case 964:	$fee = 7643;	break;
						case 965:	$fee = 7650.9;	break;
						case 966:	$fee = 7658.8;	break;
						case 967:	$fee = 7666.7;	break;
						case 968:	$fee = 7674.7;	break;
						case 969:	$fee = 7682.6;	break;
						case 970:	$fee = 7690.5;	break;
						case 971:	$fee = 7698.5;	break;
						case 972:	$fee = 7706.4;	break;
						case 973:	$fee = 7714.3;	break;
						case 974:	$fee = 7722.2;	break;
						case 975:	$fee = 7730.2;	break;
						case 976:	$fee = 7738.1;	break;
						case 977:	$fee = 7746;	break;
						case 978:	$fee = 7754;	break;
						case 979:	$fee = 7761.9;	break;
						case 980:	$fee = 7769.8;	break;
						case 981:	$fee = 7777.7;	break;
						case 982:	$fee = 7785.7;	break;
						case 983:	$fee = 7793.6;	break;
						case 984:	$fee = 7801.5;	break;
						case 985:	$fee = 7809.4;	break;
						case 986:	$fee = 7817.4;	break;
						case 987:	$fee = 7825.3;	break;
						case 988:	$fee = 7833.2;	break;
						case 989:	$fee = 7841.2;	break;
						case 990:	$fee = 7849.1;	break;
						case 991:	$fee = 7857;	break;
						case 992:	$fee = 7864.9;	break;
						case 993:	$fee = 7872.9;	break;
						case 994:	$fee = 7880.8;	break;
						case 995:	$fee = 7888.7;	break;
						case 996:	$fee = 7896.7;	break;
						case 997:	$fee = 7904.6;	break;
						case 998:	$fee = 7912.5;	break;
						case 999:	$fee = 7920.4;	break;
						case 1000:	$fee = 7928.4;	break;

						default:
							$fee = ceil(1.1 * $org_fee / 18.5);
							break;
					}
				break;
				default:
					$fee = ceil(1.1 * $org_fee / 18.5);
					break;
			}
		}

		return $fee;
	}

}
