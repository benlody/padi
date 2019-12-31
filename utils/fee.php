
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
						$fee = ceil($weight / 18) * 11;
					}
				break;
				case 'GreenIsland': 
					if(ShippingType::T_BLACKCAT == $type){
						$fee = ceil($weight / 18) * 19.8;
					} else {
						$fee = ceil($weight / 18) * 11;
					}
				break;
				case 'Liuqiu_Henchun': 
					if(ShippingType::T_BLACKCAT == $type){
						$fee = round(ceil($weight / 18) * 13.75 + 0.05, 1);
					} else {
						$fee = ceil($weight / 18) * 11;
					}
				break;
				case 'Korea': 
					$fee = round((floor($weight/20)*1780 + ($weight%20)*80 + 180)*1.1/20 + 0.0499, 1);
				break;
				case 'HongKong': 
					switch ($weight){
						case 1:	$fee = 6.30;	break;
						case 2:	$fee = 11.90;	break;
						case 3:	$fee = 17.10;	break;
						case 4:	$fee = 23.10;	break;
						case 5:	$fee = 29.10;	break;
						case 6:	$fee = 35.00;	break;
						case 7:	$fee = 41.00;	break;
						case 8:	$fee = 47.00;	break;
						case 9:	$fee = 52.90;	break;
						case 10:	$fee = 58.90;	break;
						case 11:	$fee = 64.90;	break;
						case 12:	$fee = 70.80;	break;
						case 13:	$fee = 76.80;	break;
						case 14:	$fee = 82.80;	break;
						case 15:	$fee = 88.70;	break;
						case 16:	$fee = 94.70;	break;
						case 17:	$fee = 100.70;	break;
						case 18:	$fee = 106.60;	break;
						case 19:	$fee = 112.60;	break;
						case 20:	$fee = 118.10;	break;
						case 21:	$fee = 124.00;	break;
						case 22:	$fee = 129.90;	break;
						case 23:	$fee = 135.80;	break;
						case 24:	$fee = 141.80;	break;
						case 25:	$fee = 147.70;	break;
						case 26:	$fee = 153.60;	break;
						case 27:	$fee = 159.50;	break;
						case 28:	$fee = 165.40;	break;
						case 29:	$fee = 171.30;	break;
						case 30:	$fee = 177.20;	break;
						case 31:	$fee = 183.10;	break;
						case 32:	$fee = 189.00;	break;
						case 33:	$fee = 194.90;	break;
						case 34:	$fee = 200.80;	break;
						case 35:	$fee = 206.70;	break;
						case 36:	$fee = 212.60;	break;
						case 37:	$fee = 218.50;	break;
						case 38:	$fee = 224.40;	break;
						case 39:	$fee = 230.30;	break;
						case 40:	$fee = 236.20;	break;
						case 41:	$fee = 242.10;	break;
						case 42:	$fee = 248.00;	break;
						case 43:	$fee = 253.90;	break;
						case 44:	$fee = 259.80;	break;
						case 45:	$fee = 265.70;	break;
						case 46:	$fee = 271.60;	break;
						case 47:	$fee = 277.50;	break;
						case 48:	$fee = 283.50;	break;
						case 49:	$fee = 289.40;	break;
						case 50:	$fee = 295.30;	break;
						case 51:	$fee = 301.20;	break;
						case 52:	$fee = 307.10;	break;
						case 53:	$fee = 313.00;	break;
						case 54:	$fee = 318.90;	break;
						case 55:	$fee = 324.80;	break;
						case 56:	$fee = 330.70;	break;
						case 57:	$fee = 336.60;	break;
						case 58:	$fee = 342.50;	break;
						case 59:	$fee = 348.40;	break;
						case 60:	$fee = 354.30;	break;
						case 61:	$fee = 360.20;	break;
						case 62:	$fee = 366.10;	break;
						case 63:	$fee = 372.00;	break;
						case 64:	$fee = 377.90;	break;
						case 65:	$fee = 383.80;	break;
						case 66:	$fee = 389.70;	break;
						case 67:	$fee = 395.60;	break;
						case 68:	$fee = 401.50;	break;
						case 69:	$fee = 407.40;	break;
						case 70:	$fee = 413.30;	break;
						case 71:	$fee = 419.30;	break;
						case 72:	$fee = 425.20;	break;
						case 73:	$fee = 431.10;	break;
						case 74:	$fee = 437.00;	break;
						case 75:	$fee = 442.90;	break;
						case 76:	$fee = 448.80;	break;
						case 77:	$fee = 454.70;	break;
						case 78:	$fee = 460.60;	break;
						case 79:	$fee = 466.50;	break;
						case 80:	$fee = 472.40;	break;
						case 81:	$fee = 478.30;	break;
						case 82:	$fee = 484.20;	break;
						case 83:	$fee = 490.10;	break;
						case 84:	$fee = 496.00;	break;
						case 85:	$fee = 501.90;	break;
						case 86:	$fee = 507.80;	break;
						case 87:	$fee = 513.70;	break;
						case 88:	$fee = 519.60;	break;
						case 89:	$fee = 525.50;	break;
						case 90:	$fee = 531.40;	break;
						case 91:	$fee = 537.30;	break;
						case 92:	$fee = 543.20;	break;
						case 93:	$fee = 549.10;	break;
						case 94:	$fee = 555.00;	break;
						case 95:	$fee = 561.00;	break;
						case 96:	$fee = 566.90;	break;
						case 97:	$fee = 572.80;	break;
						case 98:	$fee = 578.70;	break;
						case 99:	$fee = 584.60;	break;
						case 100:	$fee = 590.50;	break;
						case 101:	$fee = 596.40;	break;
						case 102:	$fee = 602.30;	break;
						case 103:	$fee = 608.20;	break;
						case 104:	$fee = 614.10;	break;
						case 105:	$fee = 620.00;	break;
						case 106:	$fee = 625.90;	break;
						case 107:	$fee = 631.80;	break;
						case 108:	$fee = 637.70;	break;
						case 109:	$fee = 643.60;	break;
						case 110:	$fee = 649.50;	break;
						case 111:	$fee = 655.40;	break;
						case 112:	$fee = 661.30;	break;
						case 113:	$fee = 667.20;	break;
						case 114:	$fee = 673.10;	break;
						case 115:	$fee = 679.00;	break;
						case 116:	$fee = 684.90;	break;
						case 117:	$fee = 690.80;	break;
						case 118:	$fee = 696.80;	break;
						case 119:	$fee = 702.70;	break;
						case 120:	$fee = 708.60;	break;
						case 121:	$fee = 714.50;	break;
						case 122:	$fee = 720.40;	break;
						case 123:	$fee = 726.30;	break;
						case 124:	$fee = 732.20;	break;
						case 125:	$fee = 738.10;	break;
						case 126:	$fee = 744.00;	break;
						case 127:	$fee = 749.90;	break;
						case 128:	$fee = 755.80;	break;
						case 129:	$fee = 761.70;	break;
						case 130:	$fee = 767.60;	break;
						case 131:	$fee = 773.50;	break;
						case 132:	$fee = 779.40;	break;
						case 133:	$fee = 785.30;	break;
						case 134:	$fee = 791.20;	break;
						case 135:	$fee = 797.10;	break;
						case 136:	$fee = 803.00;	break;
						case 137:	$fee = 808.90;	break;
						case 138:	$fee = 814.80;	break;
						case 139:	$fee = 820.70;	break;
						case 140:	$fee = 826.60;	break;
						case 141:	$fee = 832.50;	break;
						case 142:	$fee = 838.50;	break;
						case 143:	$fee = 844.40;	break;
						case 144:	$fee = 850.30;	break;
						case 145:	$fee = 856.20;	break;
						case 146:	$fee = 862.10;	break;
						case 147:	$fee = 868.00;	break;
						case 148:	$fee = 873.90;	break;
						case 149:	$fee = 879.80;	break;
						case 150:	$fee = 885.70;	break;
						case 151:	$fee = 891.60;	break;
						case 152:	$fee = 897.50;	break;
						case 153:	$fee = 903.40;	break;
						case 154:	$fee = 909.30;	break;
						case 155:	$fee = 915.20;	break;
						case 156:	$fee = 921.10;	break;
						case 157:	$fee = 927.00;	break;
						case 158:	$fee = 932.90;	break;
						case 159:	$fee = 938.80;	break;
						case 160:	$fee = 944.70;	break;
						case 161:	$fee = 950.60;	break;
						case 162:	$fee = 956.50;	break;
						case 163:	$fee = 962.40;	break;
						case 164:	$fee = 968.30;	break;
						case 165:	$fee = 974.30;	break;
						case 166:	$fee = 980.20;	break;
						case 167:	$fee = 986.10;	break;
						case 168:	$fee = 992.00;	break;
						case 169:	$fee = 997.90;	break;
						case 170:	$fee = 1003.80;	break;
						case 171:	$fee = 1009.70;	break;
						case 172:	$fee = 1015.60;	break;
						case 173:	$fee = 1021.50;	break;
						case 174:	$fee = 1027.40;	break;
						case 175:	$fee = 1033.30;	break;
						case 176:	$fee = 1039.20;	break;
						case 177:	$fee = 1045.10;	break;
						case 178:	$fee = 1051.00;	break;
						case 179:	$fee = 1056.90;	break;
						case 180:	$fee = 1062.80;	break;
						case 181:	$fee = 1068.70;	break;
						case 182:	$fee = 1074.60;	break;
						case 183:	$fee = 1080.50;	break;
						case 184:	$fee = 1086.40;	break;
						case 185:	$fee = 1092.30;	break;
						case 186:	$fee = 1098.20;	break;
						case 187:	$fee = 1104.10;	break;
						case 188:	$fee = 1110.00;	break;
						case 189:	$fee = 1116.00;	break;
						case 190:	$fee = 1121.90;	break;
						case 191:	$fee = 1127.80;	break;
						case 192:	$fee = 1133.70;	break;
						case 193:	$fee = 1139.60;	break;
						case 194:	$fee = 1145.50;	break;
						case 195:	$fee = 1151.40;	break;
						case 196:	$fee = 1157.30;	break;
						case 197:	$fee = 1163.20;	break;
						case 198:	$fee = 1169.10;	break;
						case 199:	$fee = 1175.00;	break;
						case 200:	$fee = 1180.90;	break;
						case 201:	$fee = 1186.80;	break;
						case 202:	$fee = 1192.70;	break;
						case 203:	$fee = 1198.60;	break;
						case 204:	$fee = 1204.50;	break;
						case 205:	$fee = 1210.40;	break;
						case 206:	$fee = 1216.30;	break;
						case 207:	$fee = 1222.20;	break;
						case 208:	$fee = 1228.10;	break;
						case 209:	$fee = 1234.00;	break;
						case 210:	$fee = 1239.90;	break;
						case 211:	$fee = 1245.80;	break;
						case 212:	$fee = 1251.80;	break;
						case 213:	$fee = 1257.70;	break;
						case 214:	$fee = 1263.60;	break;
						case 215:	$fee = 1269.50;	break;
						case 216:	$fee = 1275.40;	break;
						case 217:	$fee = 1281.30;	break;
						case 1900-08-05:	$fee = 1287.20;	break;
						case 219:	$fee = 1293.10;	break;
						case 1900-08-07:	$fee = 1299.00;	break;
						case 1900-08-08:	$fee = 1304.90;	break;
						case 1900-08-09:	$fee = 1310.80;	break;
						case 1900-08-10:	$fee = 1316.70;	break;
						case 1900-08-11:	$fee = 1322.60;	break;
						case 1900-08-12:	$fee = 1328.50;	break;
						case 1900-08-13:	$fee = 1334.40;	break;
						case 1900-08-14:	$fee = 1340.30;	break;
						case 1900-08-15:	$fee = 1346.20;	break;
						case 1900-08-16:	$fee = 1352.10;	break;
						case 1900-08-17:	$fee = 1358.00;	break;
						case 1900-08-18:	$fee = 1363.90;	break;
						case 1900-08-19:	$fee = 1369.80;	break;
						case 1900-08-20:	$fee = 1375.70;	break;
						case 1900-08-21:	$fee = 1381.60;	break;
						case 1900-08-22:	$fee = 1387.50;	break;
						case 1900-08-23:	$fee = 1393.50;	break;
						case 1900-08-24:	$fee = 1399.40;	break;
						case 1900-08-25:	$fee = 1405.30;	break;
						case 1900-08-26:	$fee = 1411.20;	break;
						case 1900-08-27:	$fee = 1417.10;	break;
						case 1900-08-28:	$fee = 1423.00;	break;
						case 1900-08-29:	$fee = 1428.90;	break;
						case 1900-08-30:	$fee = 1434.80;	break;
						case 1900-08-31:	$fee = 1440.70;	break;
						case 1900-09-01:	$fee = 1446.60;	break;
						case 1900-09-02:	$fee = 1452.50;	break;
						case 1900-09-03:	$fee = 1458.40;	break;
						case 1900-09-04:	$fee = 1464.30;	break;
						case 1900-09-05:	$fee = 1470.20;	break;
						case 1900-09-06:	$fee = 1476.10;	break;
						case 1900-09-07:	$fee = 1482.00;	break;
						case 1900-09-08:	$fee = 1487.90;	break;
						case 1900-09-09:	$fee = 1493.80;	break;
						case 1900-09-10:	$fee = 1499.70;	break;
						case 1900-09-11:	$fee = 1505.60;	break;
						case 1900-09-12:	$fee = 1511.50;	break;
						case 1900-09-13:	$fee = 1517.40;	break;
						case 1900-09-14:	$fee = 1523.30;	break;
						case 1900-09-15:	$fee = 1529.30;	break;
						case 1900-09-16:	$fee = 1535.20;	break;
						case 1900-09-17:	$fee = 1541.10;	break;
						case 1900-09-18:	$fee = 1547.00;	break;
						case 1900-09-19:	$fee = 1552.90;	break;
						case 1900-09-20:	$fee = 1558.80;	break;
						case 1900-09-21:	$fee = 1564.70;	break;
						case 1900-09-22:	$fee = 1570.60;	break;
						case 1900-09-23:	$fee = 1576.50;	break;
						case 1900-09-24:	$fee = 1582.40;	break;
						case 1900-09-25:	$fee = 1588.30;	break;
						case 1900-09-26:	$fee = 1594.20;	break;
						case 1900-09-27:	$fee = 1600.10;	break;
						case 1900-09-28:	$fee = 1606.00;	break;
						case 273:	$fee = 1611.90;	break;
						case 274:	$fee = 1617.80;	break;
						case 275:	$fee = 1623.70;	break;
						case 276:	$fee = 1629.60;	break;
						case 277:	$fee = 1635.50;	break;
						case 278:	$fee = 1641.40;	break;
						case 279:	$fee = 1647.30;	break;
						case 280:	$fee = 1653.20;	break;
						case 281:	$fee = 1659.10;	break;
						case 282:	$fee = 1665.00;	break;
						case 283:	$fee = 1671.00;	break;
						case 284:	$fee = 1676.90;	break;
						case 285:	$fee = 1682.80;	break;
						case 286:	$fee = 1688.70;	break;
						case 287:	$fee = 1694.60;	break;
						case 288:	$fee = 1700.50;	break;
						case 289:	$fee = 1706.40;	break;
						case 290:	$fee = 1712.30;	break;
						case 291:	$fee = 1718.20;	break;
						case 292:	$fee = 1724.10;	break;
						case 293:	$fee = 1730.00;	break;
						case 294:	$fee = 1735.90;	break;
						case 295:	$fee = 1741.80;	break;
						case 296:	$fee = 1747.70;	break;
						case 297:	$fee = 1753.60;	break;
						case 298:	$fee = 1759.50;	break;
						case 299:	$fee = 1765.40;	break;
						case 300:	$fee = 1771.30;	break;
						case 301:	$fee = 1777.20;	break;
						case 302:	$fee = 1783.10;	break;
						case 303:	$fee = 1789.00;	break;
						case 304:	$fee = 1794.90;	break;
						case 305:	$fee = 1800.80;	break;
						case 306:	$fee = 1806.80;	break;
						case 307:	$fee = 1812.70;	break;
						case 308:	$fee = 1818.60;	break;
						case 309:	$fee = 1824.50;	break;
						case 310:	$fee = 1830.40;	break;
						case 311:	$fee = 1836.30;	break;
						case 312:	$fee = 1842.20;	break;
						case 313:	$fee = 1848.10;	break;
						case 314:	$fee = 1854.00;	break;
						case 315:	$fee = 1859.90;	break;
						case 316:	$fee = 1865.80;	break;
						case 317:	$fee = 1871.70;	break;
						case 318:	$fee = 1877.60;	break;
						case 319:	$fee = 1883.50;	break;
						case 320:	$fee = 1889.40;	break;
						case 321:	$fee = 1895.30;	break;
						case 322:	$fee = 1901.20;	break;
						case 323:	$fee = 1907.10;	break;
						case 324:	$fee = 1913.00;	break;
						case 325:	$fee = 1918.90;	break;
						case 326:	$fee = 1924.80;	break;
						case 327:	$fee = 1930.70;	break;
						case 328:	$fee = 1936.60;	break;
						case 329:	$fee = 1942.50;	break;
						case 330:	$fee = 1948.50;	break;
						case 331:	$fee = 1954.40;	break;
						case 332:	$fee = 1960.30;	break;
						case 333:	$fee = 1966.20;	break;
						case 334:	$fee = 1972.10;	break;
						case 335:	$fee = 1978.00;	break;
						case 336:	$fee = 1983.90;	break;
						case 337:	$fee = 1989.80;	break;
						case 338:	$fee = 1995.70;	break;
						case 339:	$fee = 2001.60;	break;
						case 340:	$fee = 2007.50;	break;
						case 341:	$fee = 2013.40;	break;
						case 342:	$fee = 2019.30;	break;
						case 343:	$fee = 2025.20;	break;
						case 344:	$fee = 2031.10;	break;
						case 345:	$fee = 2037.00;	break;
						case 346:	$fee = 2042.90;	break;
						case 347:	$fee = 2048.80;	break;
						case 348:	$fee = 2054.70;	break;
						case 349:	$fee = 2060.60;	break;
						case 350:	$fee = 2066.50;	break;
						case 351:	$fee = 2072.40;	break;
						case 352:	$fee = 2078.30;	break;
						case 353:	$fee = 2084.30;	break;
						case 354:	$fee = 2090.20;	break;
						case 355:	$fee = 2096.10;	break;
						case 356:	$fee = 2102.00;	break;
						case 357:	$fee = 2107.90;	break;
						case 358:	$fee = 2113.80;	break;
						case 359:	$fee = 2119.70;	break;
						case 360:	$fee = 2125.60;	break;
						case 361:	$fee = 2131.50;	break;
						case 362:	$fee = 2137.40;	break;
						case 363:	$fee = 2143.30;	break;
						case 364:	$fee = 2149.20;	break;
						case 365:	$fee = 2155.10;	break;
						case 366:	$fee = 2161.00;	break;
						case 367:	$fee = 2166.90;	break;
						case 368:	$fee = 2172.80;	break;
						case 369:	$fee = 2178.70;	break;
						case 370:	$fee = 2184.60;	break;
						case 371:	$fee = 2190.50;	break;
						case 372:	$fee = 2196.40;	break;
						case 373:	$fee = 2202.30;	break;
						case 374:	$fee = 2208.20;	break;
						case 375:	$fee = 2214.10;	break;
						case 376:	$fee = 2220.00;	break;
						case 377:	$fee = 2226.00;	break;
						case 378:	$fee = 2231.90;	break;
						case 379:	$fee = 2237.80;	break;
						case 380:	$fee = 2243.70;	break;
						case 381:	$fee = 2249.60;	break;
						case 382:	$fee = 2255.50;	break;
						case 383:	$fee = 2261.40;	break;
						case 384:	$fee = 2267.30;	break;
						case 385:	$fee = 2273.20;	break;
						case 386:	$fee = 2279.10;	break;
						case 387:	$fee = 2285.00;	break;
						case 388:	$fee = 2290.90;	break;
						case 389:	$fee = 2296.80;	break;
						case 390:	$fee = 2302.70;	break;
						case 391:	$fee = 2308.60;	break;
						case 392:	$fee = 2314.50;	break;
						case 393:	$fee = 2320.40;	break;
						case 394:	$fee = 2326.30;	break;
						case 395:	$fee = 2332.20;	break;
						case 396:	$fee = 2338.10;	break;
						case 397:	$fee = 2344.00;	break;
						case 398:	$fee = 2349.90;	break;
						case 399:	$fee = 2355.80;	break;
						case 400:	$fee = 2361.70;	break;
						case 401:	$fee = 2367.70;	break;
						case 402:	$fee = 2373.60;	break;
						case 403:	$fee = 2379.50;	break;
						case 404:	$fee = 2385.40;	break;
						case 405:	$fee = 2391.30;	break;
						case 406:	$fee = 2397.20;	break;
						case 407:	$fee = 2403.10;	break;
						case 408:	$fee = 2409.00;	break;
						case 409:	$fee = 2414.90;	break;
						case 410:	$fee = 2420.80;	break;
						case 411:	$fee = 2426.70;	break;
						case 412:	$fee = 2432.60;	break;
						case 413:	$fee = 2438.50;	break;
						case 414:	$fee = 2444.40;	break;
						case 415:	$fee = 2450.30;	break;
						case 416:	$fee = 2456.20;	break;
						case 417:	$fee = 2462.10;	break;
						case 418:	$fee = 2468.00;	break;
						case 419:	$fee = 2473.90;	break;
						case 420:	$fee = 2479.80;	break;
						case 421:	$fee = 2485.70;	break;
						case 422:	$fee = 2491.60;	break;
						case 423:	$fee = 2497.50;	break;
						case 424:	$fee = 2503.50;	break;
						case 425:	$fee = 2509.40;	break;
						case 426:	$fee = 2515.30;	break;
						case 427:	$fee = 2521.20;	break;
						case 428:	$fee = 2527.10;	break;
						case 429:	$fee = 2533.00;	break;
						case 430:	$fee = 2538.90;	break;
						case 431:	$fee = 2544.80;	break;
						case 432:	$fee = 2550.70;	break;
						case 433:	$fee = 2556.60;	break;
						case 434:	$fee = 2562.50;	break;
						case 435:	$fee = 2568.40;	break;
						case 436:	$fee = 2574.30;	break;
						case 437:	$fee = 2580.20;	break;
						case 438:	$fee = 2586.10;	break;
						case 439:	$fee = 2592.00;	break;
						case 440:	$fee = 2597.90;	break;
						case 441:	$fee = 2603.80;	break;
						case 442:	$fee = 2609.70;	break;
						case 443:	$fee = 2615.60;	break;
						case 444:	$fee = 2621.50;	break;
						case 445:	$fee = 2627.40;	break;
						case 446:	$fee = 2633.30;	break;
						case 447:	$fee = 2639.20;	break;
						case 448:	$fee = 2645.20;	break;
						case 449:	$fee = 2651.10;	break;
						case 450:	$fee = 2657.00;	break;
						case 451:	$fee = 2662.90;	break;
						case 452:	$fee = 2668.80;	break;
						case 453:	$fee = 2674.70;	break;
						case 454:	$fee = 2680.60;	break;
						case 455:	$fee = 2686.50;	break;
						case 456:	$fee = 2692.40;	break;
						case 457:	$fee = 2698.30;	break;
						case 458:	$fee = 2704.20;	break;
						case 459:	$fee = 2710.10;	break;
						case 460:	$fee = 2716.00;	break;
						case 461:	$fee = 2721.90;	break;
						case 462:	$fee = 2727.80;	break;
						case 463:	$fee = 2733.70;	break;
						case 464:	$fee = 2739.60;	break;
						case 465:	$fee = 2745.50;	break;
						case 466:	$fee = 2751.40;	break;
						case 467:	$fee = 2757.30;	break;
						case 468:	$fee = 2763.20;	break;
						case 469:	$fee = 2769.10;	break;
						case 470:	$fee = 2775.00;	break;
						case 471:	$fee = 2781.00;	break;
						case 472:	$fee = 2786.90;	break;
						case 473:	$fee = 2792.80;	break;
						case 474:	$fee = 2798.70;	break;
						case 475:	$fee = 2804.60;	break;
						case 476:	$fee = 2810.50;	break;
						case 477:	$fee = 2816.40;	break;
						case 478:	$fee = 2822.30;	break;
						case 479:	$fee = 2828.20;	break;
						case 480:	$fee = 2834.10;	break;
						case 481:	$fee = 2840.00;	break;
						case 482:	$fee = 2845.90;	break;
						case 483:	$fee = 2851.80;	break;
						case 484:	$fee = 2857.70;	break;
						case 485:	$fee = 2863.60;	break;
						case 486:	$fee = 2869.50;	break;
						case 487:	$fee = 2875.40;	break;
						case 488:	$fee = 2881.30;	break;
						case 489:	$fee = 2887.20;	break;
						case 490:	$fee = 2893.10;	break;
						case 491:	$fee = 2899.00;	break;
						case 492:	$fee = 2904.90;	break;
						case 493:	$fee = 2910.80;	break;
						case 494:	$fee = 2916.70;	break;
						case 495:	$fee = 2922.70;	break;
						case 496:	$fee = 2928.60;	break;
						case 497:	$fee = 2934.50;	break;
						case 498:	$fee = 2940.40;	break;
						case 499:	$fee = 2946.30;	break;
						case 500:	$fee = 2952.20;	break;
						case 501:	$fee = 2958.10;	break;
						case 502:	$fee = 2964.00;	break;
						case 503:	$fee = 2969.90;	break;
						case 504:	$fee = 2975.80;	break;
						case 505:	$fee = 2981.70;	break;
						case 506:	$fee = 2987.60;	break;
						case 507:	$fee = 2993.50;	break;
						case 508:	$fee = 2999.40;	break;
						case 509:	$fee = 3005.30;	break;
						case 510:	$fee = 3011.20;	break;
						case 511:	$fee = 3017.10;	break;
						case 512:	$fee = 3023.00;	break;
						case 513:	$fee = 3028.90;	break;
						case 514:	$fee = 3034.80;	break;
						case 515:	$fee = 3040.70;	break;
						case 516:	$fee = 3046.60;	break;
						case 517:	$fee = 3052.50;	break;
						case 518:	$fee = 3058.50;	break;
						case 519:	$fee = 3064.40;	break;
						case 520:	$fee = 3070.30;	break;
						case 521:	$fee = 3076.20;	break;
						case 522:	$fee = 3082.10;	break;
						case 523:	$fee = 3088.00;	break;
						case 524:	$fee = 3093.90;	break;
						case 525:	$fee = 3099.80;	break;
						case 526:	$fee = 3105.70;	break;
						case 527:	$fee = 3111.60;	break;
						case 528:	$fee = 3117.50;	break;
						case 529:	$fee = 3123.40;	break;
						case 530:	$fee = 3129.30;	break;
						case 531:	$fee = 3135.20;	break;
						case 532:	$fee = 3141.10;	break;
						case 533:	$fee = 3147.00;	break;
						case 534:	$fee = 3152.90;	break;
						case 535:	$fee = 3158.80;	break;
						case 536:	$fee = 3164.70;	break;
						case 537:	$fee = 3170.60;	break;
						case 538:	$fee = 3176.50;	break;
						case 539:	$fee = 3182.40;	break;
						case 540:	$fee = 3188.30;	break;
						case 541:	$fee = 3194.20;	break;
						case 542:	$fee = 3200.20;	break;
						case 543:	$fee = 3206.10;	break;
						case 544:	$fee = 3212.00;	break;
						case 545:	$fee = 3217.90;	break;
						case 546:	$fee = 3223.80;	break;
						case 547:	$fee = 3229.70;	break;
						case 548:	$fee = 3235.60;	break;
						case 549:	$fee = 3241.50;	break;
						case 550:	$fee = 3247.40;	break;
						case 551:	$fee = 3253.30;	break;
						case 552:	$fee = 3259.20;	break;
						case 553:	$fee = 3265.10;	break;
						case 554:	$fee = 3271.00;	break;
						case 555:	$fee = 3276.90;	break;
						case 556:	$fee = 3282.80;	break;
						case 557:	$fee = 3288.70;	break;
						case 558:	$fee = 3294.60;	break;
						case 559:	$fee = 3300.50;	break;
						case 560:	$fee = 3306.40;	break;
						case 561:	$fee = 3312.30;	break;
						case 562:	$fee = 3318.20;	break;
						case 563:	$fee = 3324.10;	break;
						case 564:	$fee = 3330.00;	break;
						case 565:	$fee = 3336.00;	break;
						case 566:	$fee = 3341.90;	break;
						case 567:	$fee = 3347.80;	break;
						case 568:	$fee = 3353.70;	break;
						case 569:	$fee = 3359.60;	break;
						case 570:	$fee = 3365.50;	break;
						case 571:	$fee = 3371.40;	break;
						case 572:	$fee = 3377.30;	break;
						case 573:	$fee = 3383.20;	break;
						case 574:	$fee = 3389.10;	break;
						case 575:	$fee = 3395.00;	break;
						case 576:	$fee = 3400.90;	break;
						case 577:	$fee = 3406.80;	break;
						case 578:	$fee = 3412.70;	break;
						case 579:	$fee = 3418.60;	break;
						case 580:	$fee = 3424.50;	break;
						case 581:	$fee = 3430.40;	break;
						case 582:	$fee = 3436.30;	break;
						case 583:	$fee = 3442.20;	break;
						case 584:	$fee = 3448.10;	break;
						case 585:	$fee = 3454.00;	break;
						case 586:	$fee = 3459.90;	break;
						case 587:	$fee = 3465.80;	break;
						case 588:	$fee = 3471.70;	break;
						case 589:	$fee = 3477.70;	break;
						case 590:	$fee = 3483.60;	break;
						case 591:	$fee = 3489.50;	break;
						case 592:	$fee = 3495.40;	break;
						case 593:	$fee = 3501.30;	break;
						case 594:	$fee = 3507.20;	break;
						case 595:	$fee = 3513.10;	break;
						case 596:	$fee = 3519.00;	break;
						case 597:	$fee = 3524.90;	break;
						case 598:	$fee = 3530.80;	break;
						case 599:	$fee = 3536.70;	break;
						case 600:	$fee = 3542.60;	break;
						case 601:	$fee = 3548.50;	break;
						case 602:	$fee = 3554.40;	break;
						case 603:	$fee = 3560.30;	break;
						case 604:	$fee = 3566.20;	break;
						case 605:	$fee = 3572.10;	break;
						case 606:	$fee = 3578.00;	break;
						case 607:	$fee = 3583.90;	break;
						case 608:	$fee = 3589.80;	break;
						case 609:	$fee = 3595.70;	break;
						case 610:	$fee = 3601.60;	break;
						case 611:	$fee = 3607.50;	break;
						case 612:	$fee = 3613.50;	break;
						case 613:	$fee = 3619.40;	break;
						case 614:	$fee = 3625.30;	break;
						case 615:	$fee = 3631.20;	break;
						case 616:	$fee = 3637.10;	break;
						case 617:	$fee = 3643.00;	break;
						case 618:	$fee = 3648.90;	break;
						case 619:	$fee = 3654.80;	break;
						case 620:	$fee = 3660.70;	break;
						case 621:	$fee = 3666.60;	break;
						case 622:	$fee = 3672.50;	break;
						case 623:	$fee = 3678.40;	break;
						case 624:	$fee = 3684.30;	break;
						case 625:	$fee = 3690.20;	break;
						case 626:	$fee = 3696.10;	break;
						case 627:	$fee = 3702.00;	break;
						case 628:	$fee = 3707.90;	break;
						case 629:	$fee = 3713.80;	break;
						case 630:	$fee = 3719.70;	break;
						case 631:	$fee = 3725.60;	break;
						case 632:	$fee = 3731.50;	break;
						case 633:	$fee = 3737.40;	break;
						case 634:	$fee = 3743.30;	break;
						case 635:	$fee = 3749.20;	break;
						case 636:	$fee = 3755.20;	break;
						case 637:	$fee = 3761.10;	break;
						case 638:	$fee = 3767.00;	break;
						case 639:	$fee = 3772.90;	break;
						case 640:	$fee = 3778.80;	break;
						case 641:	$fee = 3784.70;	break;
						case 642:	$fee = 3790.60;	break;
						case 643:	$fee = 3796.50;	break;
						case 644:	$fee = 3802.40;	break;
						case 645:	$fee = 3808.30;	break;
						case 646:	$fee = 3814.20;	break;
						case 647:	$fee = 3820.10;	break;
						case 648:	$fee = 3826.00;	break;
						case 649:	$fee = 3831.90;	break;
						case 650:	$fee = 3837.80;	break;
						case 651:	$fee = 3843.70;	break;
						case 652:	$fee = 3849.60;	break;
						case 653:	$fee = 3855.50;	break;
						case 654:	$fee = 3861.40;	break;
						case 655:	$fee = 3867.30;	break;
						case 656:	$fee = 3873.20;	break;
						case 657:	$fee = 3879.10;	break;
						case 658:	$fee = 3885.00;	break;
						case 659:	$fee = 3891.00;	break;
						case 660:	$fee = 3896.90;	break;
						case 661:	$fee = 3902.80;	break;
						case 662:	$fee = 3908.70;	break;
						case 663:	$fee = 3914.60;	break;
						case 664:	$fee = 3920.50;	break;
						case 665:	$fee = 3926.40;	break;
						case 666:	$fee = 3932.30;	break;
						case 667:	$fee = 3938.20;	break;
						case 668:	$fee = 3944.10;	break;
						case 669:	$fee = 3950.00;	break;
						case 670:	$fee = 3955.90;	break;
						case 671:	$fee = 3961.80;	break;
						case 672:	$fee = 3967.70;	break;
						case 673:	$fee = 3973.60;	break;
						case 674:	$fee = 3979.50;	break;
						case 675:	$fee = 3985.40;	break;
						case 676:	$fee = 3991.30;	break;
						case 677:	$fee = 3997.20;	break;
						case 678:	$fee = 4003.10;	break;
						case 679:	$fee = 4009.00;	break;
						case 680:	$fee = 4014.90;	break;
						case 681:	$fee = 4020.80;	break;
						case 682:	$fee = 4026.70;	break;
						case 683:	$fee = 4032.70;	break;
						case 684:	$fee = 4038.60;	break;
						case 685:	$fee = 4044.50;	break;
						case 686:	$fee = 4050.40;	break;
						case 687:	$fee = 4056.30;	break;
						case 688:	$fee = 4062.20;	break;
						case 689:	$fee = 4068.10;	break;
						case 690:	$fee = 4074.00;	break;
						case 691:	$fee = 4079.90;	break;
						case 692:	$fee = 4085.80;	break;
						case 693:	$fee = 4091.70;	break;
						case 694:	$fee = 4097.60;	break;
						case 695:	$fee = 4103.50;	break;
						case 696:	$fee = 4109.40;	break;
						case 697:	$fee = 4115.30;	break;
						case 698:	$fee = 4121.20;	break;
						case 699:	$fee = 4127.10;	break;
						case 700:	$fee = 4133.00;	break;
						case 701:	$fee = 4138.90;	break;
						case 702:	$fee = 4144.80;	break;
						case 703:	$fee = 4150.70;	break;
						case 704:	$fee = 4156.60;	break;
						case 705:	$fee = 4162.50;	break;
						case 706:	$fee = 4168.50;	break;
						case 707:	$fee = 4174.40;	break;
						case 708:	$fee = 4180.30;	break;
						case 709:	$fee = 4186.20;	break;
						case 710:	$fee = 4192.10;	break;
						case 711:	$fee = 4198.00;	break;
						case 712:	$fee = 4203.90;	break;
						case 713:	$fee = 4209.80;	break;
						case 714:	$fee = 4215.70;	break;
						case 715:	$fee = 4221.60;	break;
						case 716:	$fee = 4227.50;	break;
						case 717:	$fee = 4233.40;	break;
						case 718:	$fee = 4239.30;	break;
						case 719:	$fee = 4245.20;	break;
						case 720:	$fee = 4251.10;	break;
						case 721:	$fee = 4257.00;	break;
						case 722:	$fee = 4262.90;	break;
						case 723:	$fee = 4268.80;	break;
						case 724:	$fee = 4274.70;	break;
						case 725:	$fee = 4280.60;	break;
						case 726:	$fee = 4286.50;	break;
						case 727:	$fee = 4292.40;	break;
						case 728:	$fee = 4298.30;	break;
						case 729:	$fee = 4304.20;	break;
						case 730:	$fee = 4310.20;	break;
						case 731:	$fee = 4316.10;	break;
						case 732:	$fee = 4322.00;	break;
						case 733:	$fee = 4327.90;	break;
						case 734:	$fee = 4333.80;	break;
						case 735:	$fee = 4339.70;	break;
						case 736:	$fee = 4345.60;	break;
						case 737:	$fee = 4351.50;	break;
						case 738:	$fee = 4357.40;	break;
						case 739:	$fee = 4363.30;	break;
						case 740:	$fee = 4369.20;	break;
						case 741:	$fee = 4375.10;	break;
						case 742:	$fee = 4381.00;	break;
						case 743:	$fee = 4386.90;	break;
						case 744:	$fee = 4392.80;	break;
						case 745:	$fee = 4398.70;	break;
						case 746:	$fee = 4404.60;	break;
						case 747:	$fee = 4410.50;	break;
						case 748:	$fee = 4416.40;	break;
						case 749:	$fee = 4422.30;	break;
						case 750:	$fee = 4428.20;	break;
						case 751:	$fee = 4434.10;	break;
						case 752:	$fee = 4440.00;	break;
						case 753:	$fee = 4446.00;	break;
						case 754:	$fee = 4451.90;	break;
						case 755:	$fee = 4457.80;	break;
						case 756:	$fee = 4463.70;	break;
						case 757:	$fee = 4469.60;	break;
						case 758:	$fee = 4475.50;	break;
						case 759:	$fee = 4481.40;	break;
						case 760:	$fee = 4487.30;	break;
						case 761:	$fee = 4493.20;	break;
						case 762:	$fee = 4499.10;	break;
						case 763:	$fee = 4505.00;	break;
						case 764:	$fee = 4510.90;	break;
						case 765:	$fee = 4516.80;	break;
						case 766:	$fee = 4522.70;	break;
						case 767:	$fee = 4528.60;	break;
						case 768:	$fee = 4534.50;	break;
						case 769:	$fee = 4540.40;	break;
						case 770:	$fee = 4546.30;	break;
						case 771:	$fee = 4552.20;	break;
						case 772:	$fee = 4558.10;	break;
						case 773:	$fee = 4564.00;	break;
						case 774:	$fee = 4569.90;	break;
						case 775:	$fee = 4575.80;	break;
						case 776:	$fee = 4581.70;	break;
						case 777:	$fee = 4587.70;	break;
						case 778:	$fee = 4593.60;	break;
						case 779:	$fee = 4599.50;	break;
						case 780:	$fee = 4605.40;	break;
						case 781:	$fee = 4611.30;	break;
						case 782:	$fee = 4617.20;	break;
						case 783:	$fee = 4623.10;	break;
						case 784:	$fee = 4629.00;	break;
						case 785:	$fee = 4634.90;	break;
						case 786:	$fee = 4640.80;	break;
						case 787:	$fee = 4646.70;	break;
						case 788:	$fee = 4652.60;	break;
						case 789:	$fee = 4658.50;	break;
						case 790:	$fee = 4664.40;	break;
						case 791:	$fee = 4670.30;	break;
						case 792:	$fee = 4676.20;	break;
						case 793:	$fee = 4682.10;	break;
						case 794:	$fee = 4688.00;	break;
						case 795:	$fee = 4693.90;	break;
						case 796:	$fee = 4699.80;	break;
						case 797:	$fee = 4705.70;	break;
						case 798:	$fee = 4711.60;	break;
						case 799:	$fee = 4717.50;	break;
						case 800:	$fee = 4723.40;	break;
						case 801:	$fee = 4729.40;	break;
						case 802:	$fee = 4735.30;	break;
						case 803:	$fee = 4741.20;	break;
						case 804:	$fee = 4747.10;	break;
						case 805:	$fee = 4753.00;	break;
						case 806:	$fee = 4758.90;	break;
						case 807:	$fee = 4764.80;	break;
						case 808:	$fee = 4770.70;	break;
						case 809:	$fee = 4776.60;	break;
						case 810:	$fee = 4782.50;	break;
						case 811:	$fee = 4788.40;	break;
						case 812:	$fee = 4794.30;	break;
						case 813:	$fee = 4800.20;	break;
						case 814:	$fee = 4806.10;	break;
						case 815:	$fee = 4812.00;	break;
						case 816:	$fee = 4817.90;	break;
						case 817:	$fee = 4823.80;	break;
						case 818:	$fee = 4829.70;	break;
						case 819:	$fee = 4835.60;	break;
						case 820:	$fee = 4841.50;	break;
						case 821:	$fee = 4847.40;	break;
						case 822:	$fee = 4853.30;	break;
						case 823:	$fee = 4859.20;	break;
						case 824:	$fee = 4865.20;	break;
						case 825:	$fee = 4871.10;	break;
						case 826:	$fee = 4877.00;	break;
						case 827:	$fee = 4882.90;	break;
						case 828:	$fee = 4888.80;	break;
						case 829:	$fee = 4894.70;	break;
						case 830:	$fee = 4900.60;	break;
						case 831:	$fee = 4906.50;	break;
						case 832:	$fee = 4912.40;	break;
						case 833:	$fee = 4918.30;	break;
						case 834:	$fee = 4924.20;	break;
						case 835:	$fee = 4930.10;	break;
						case 836:	$fee = 4936.00;	break;
						case 837:	$fee = 4941.90;	break;
						case 838:	$fee = 4947.80;	break;
						case 839:	$fee = 4953.70;	break;
						case 840:	$fee = 4959.60;	break;
						case 841:	$fee = 4965.50;	break;
						case 842:	$fee = 4971.40;	break;
						case 843:	$fee = 4977.30;	break;
						case 844:	$fee = 4983.20;	break;
						case 845:	$fee = 4989.10;	break;
						case 846:	$fee = 4995.00;	break;
						case 847:	$fee = 5000.90;	break;
						case 848:	$fee = 5006.90;	break;
						case 849:	$fee = 5012.80;	break;
						case 850:	$fee = 5018.70;	break;
						case 851:	$fee = 5024.60;	break;
						case 852:	$fee = 5030.50;	break;
						case 853:	$fee = 5036.40;	break;
						case 854:	$fee = 5042.30;	break;
						case 855:	$fee = 5048.20;	break;
						case 856:	$fee = 5054.10;	break;
						case 857:	$fee = 5060.00;	break;
						case 858:	$fee = 5065.90;	break;
						case 859:	$fee = 5071.80;	break;
						case 860:	$fee = 5077.70;	break;
						case 861:	$fee = 5083.60;	break;
						case 862:	$fee = 5089.50;	break;
						case 863:	$fee = 5095.40;	break;
						case 864:	$fee = 5101.30;	break;
						case 865:	$fee = 5107.20;	break;
						case 866:	$fee = 5113.10;	break;
						case 867:	$fee = 5119.00;	break;
						case 868:	$fee = 5124.90;	break;
						case 869:	$fee = 5130.80;	break;
						case 870:	$fee = 5136.70;	break;
						case 871:	$fee = 5142.70;	break;
						case 872:	$fee = 5148.60;	break;
						case 873:	$fee = 5154.50;	break;
						case 874:	$fee = 5160.40;	break;
						case 875:	$fee = 5166.30;	break;
						case 876:	$fee = 5172.20;	break;
						case 877:	$fee = 5178.10;	break;
						case 878:	$fee = 5184.00;	break;
						case 879:	$fee = 5189.90;	break;
						case 880:	$fee = 5195.80;	break;
						case 881:	$fee = 5201.70;	break;
						case 882:	$fee = 5207.60;	break;
						case 883:	$fee = 5213.50;	break;
						case 884:	$fee = 5219.40;	break;
						case 885:	$fee = 5225.30;	break;
						case 886:	$fee = 5231.20;	break;
						case 887:	$fee = 5237.10;	break;
						case 888:	$fee = 5243.00;	break;
						case 889:	$fee = 5248.90;	break;
						case 890:	$fee = 5254.80;	break;
						case 891:	$fee = 5260.70;	break;
						case 892:	$fee = 5266.60;	break;
						case 893:	$fee = 5272.50;	break;
						case 894:	$fee = 5278.40;	break;
						case 895:	$fee = 5284.40;	break;
						case 896:	$fee = 5290.30;	break;
						case 897:	$fee = 5296.20;	break;
						case 898:	$fee = 5302.10;	break;
						case 899:	$fee = 5308.00;	break;
						case 900:	$fee = 5313.90;	break;
						case 901:	$fee = 5319.80;	break;
						case 902:	$fee = 5325.70;	break;
						case 903:	$fee = 5331.60;	break;
						case 904:	$fee = 5337.50;	break;
						case 905:	$fee = 5343.40;	break;
						case 906:	$fee = 5349.30;	break;
						case 907:	$fee = 5355.20;	break;
						case 908:	$fee = 5361.10;	break;
						case 909:	$fee = 5367.00;	break;
						case 910:	$fee = 5372.90;	break;
						case 911:	$fee = 5378.80;	break;
						case 912:	$fee = 5384.70;	break;
						case 913:	$fee = 5390.60;	break;
						case 914:	$fee = 5396.50;	break;
						case 915:	$fee = 5402.40;	break;
						case 916:	$fee = 5408.30;	break;
						case 917:	$fee = 5414.20;	break;
						case 918:	$fee = 5420.20;	break;
						case 919:	$fee = 5426.10;	break;
						case 920:	$fee = 5432.00;	break;
						case 921:	$fee = 5437.90;	break;
						case 922:	$fee = 5443.80;	break;
						case 923:	$fee = 5449.70;	break;
						case 924:	$fee = 5455.60;	break;
						case 925:	$fee = 5461.50;	break;
						case 926:	$fee = 5467.40;	break;
						case 927:	$fee = 5473.30;	break;
						case 928:	$fee = 5479.20;	break;
						case 929:	$fee = 5485.10;	break;
						case 930:	$fee = 5491.00;	break;
						case 931:	$fee = 5496.90;	break;
						case 932:	$fee = 5502.80;	break;
						case 933:	$fee = 5508.70;	break;
						case 934:	$fee = 5514.60;	break;
						case 935:	$fee = 5520.50;	break;
						case 936:	$fee = 5526.40;	break;
						case 937:	$fee = 5532.30;	break;
						case 938:	$fee = 5538.20;	break;
						case 939:	$fee = 5544.10;	break;
						case 940:	$fee = 5550.00;	break;
						case 941:	$fee = 5555.90;	break;
						case 942:	$fee = 5561.90;	break;
						case 943:	$fee = 5567.80;	break;
						case 944:	$fee = 5573.70;	break;
						case 945:	$fee = 5579.60;	break;
						case 946:	$fee = 5585.50;	break;
						case 947:	$fee = 5591.40;	break;
						case 948:	$fee = 5597.30;	break;
						case 949:	$fee = 5603.20;	break;
						case 950:	$fee = 5609.10;	break;
						case 951:	$fee = 5615.00;	break;
						case 952:	$fee = 5620.90;	break;
						case 953:	$fee = 5626.80;	break;
						case 954:	$fee = 5632.70;	break;
						case 955:	$fee = 5638.60;	break;
						case 956:	$fee = 5644.50;	break;
						case 957:	$fee = 5650.40;	break;
						case 958:	$fee = 5656.30;	break;
						case 959:	$fee = 5662.20;	break;
						case 960:	$fee = 5668.10;	break;
						case 961:	$fee = 5674.00;	break;
						case 962:	$fee = 5679.90;	break;
						case 963:	$fee = 5685.80;	break;
						case 964:	$fee = 5691.70;	break;
						case 965:	$fee = 5697.70;	break;
						case 966:	$fee = 5703.60;	break;
						case 967:	$fee = 5709.50;	break;
						case 968:	$fee = 5715.40;	break;
						case 969:	$fee = 5721.30;	break;
						case 970:	$fee = 5727.20;	break;
						case 971:	$fee = 5733.10;	break;
						case 972:	$fee = 5739.00;	break;
						case 973:	$fee = 5744.90;	break;
						case 974:	$fee = 5750.80;	break;
						case 975:	$fee = 5756.70;	break;
						case 976:	$fee = 5762.60;	break;
						case 977:	$fee = 5768.50;	break;
						case 978:	$fee = 5774.40;	break;
						case 979:	$fee = 5780.30;	break;
						case 980:	$fee = 5786.20;	break;
						case 981:	$fee = 5792.10;	break;
						case 982:	$fee = 5798.00;	break;
						case 983:	$fee = 5803.90;	break;
						case 984:	$fee = 5809.80;	break;
						case 985:	$fee = 5815.70;	break;
						case 986:	$fee = 5821.60;	break;
						case 987:	$fee = 5827.50;	break;
						case 988:	$fee = 5833.40;	break;
						case 989:	$fee = 5839.40;	break;
						case 990:	$fee = 5845.30;	break;
						case 991:	$fee = 5851.20;	break;
						case 992:	$fee = 5857.10;	break;
						case 993:	$fee = 5863.00;	break;
						case 994:	$fee = 5868.90;	break;
						case 995:	$fee = 5874.80;	break;
						case 996:	$fee = 5880.70;	break;
						case 997:	$fee = 5886.60;	break;
						case 998:	$fee = 5892.50;	break;
						case 999:	$fee = 5898.40;	break;
						case 1000:	$fee = 5904.30;	break;
						default:
							$fee = ceil(1.1 * $org_fee / 21);
							break;
					}
				break;
				case 'Macau': 
					switch ($weight){
						case 1:	$fee = 7.80;	break;
						case 2:	$fee = 13.40;	break;
						case 3:	$fee = 19.30;	break;
						case 4:	$fee = 26.80;	break;
						case 5:	$fee = 34.20;	break;
						case 6:	$fee = 41.70;	break;
						case 7:	$fee = 49.10;	break;
						case 8:	$fee = 56.60;	break;
						case 9:	$fee = 64.10;	break;
						case 10:	$fee = 71.50;	break;
						case 11:	$fee = 79.00;	break;
						case 12:	$fee = 86.40;	break;
						case 13:	$fee = 93.90;	break;
						case 14:	$fee = 101.40;	break;
						case 15:	$fee = 108.80;	break;
						case 16:	$fee = 116.30;	break;
						case 17:	$fee = 123.70;	break;
						case 18:	$fee = 131.20;	break;
						case 19:	$fee = 138.60;	break;
						case 20:	$fee = 146.70;	break;
						case 21:	$fee = 154.10;	break;
						case 22:	$fee = 161.40;	break;
						case 23:	$fee = 168.70;	break;
						case 24:	$fee = 176.10;	break;
						case 25:	$fee = 183.40;	break;
						case 26:	$fee = 190.70;	break;
						case 27:	$fee = 198.10;	break;
						case 28:	$fee = 205.40;	break;
						case 29:	$fee = 212.70;	break;
						case 30:	$fee = 220.10;	break;
						case 31:	$fee = 227.40;	break;
						case 32:	$fee = 234.70;	break;
						case 33:	$fee = 242.10;	break;
						case 34:	$fee = 249.40;	break;
						case 35:	$fee = 256.70;	break;
						case 36:	$fee = 264.10;	break;
						case 37:	$fee = 271.40;	break;
						case 38:	$fee = 278.70;	break;
						case 39:	$fee = 286.10;	break;
						case 40:	$fee = 293.40;	break;
						case 41:	$fee = 300.70;	break;
						case 42:	$fee = 308.10;	break;
						case 43:	$fee = 315.40;	break;
						case 44:	$fee = 322.70;	break;
						case 45:	$fee = 330.10;	break;
						case 46:	$fee = 337.40;	break;
						case 47:	$fee = 344.70;	break;
						case 48:	$fee = 352.10;	break;
						case 49:	$fee = 359.40;	break;
						case 50:	$fee = 366.70;	break;
						case 51:	$fee = 374.10;	break;
						case 52:	$fee = 381.40;	break;
						case 53:	$fee = 388.70;	break;
						case 54:	$fee = 396.10;	break;
						case 55:	$fee = 403.40;	break;
						case 56:	$fee = 410.70;	break;
						case 57:	$fee = 418.10;	break;
						case 58:	$fee = 425.40;	break;
						case 59:	$fee = 432.70;	break;
						case 60:	$fee = 440.10;	break;
						case 61:	$fee = 447.40;	break;
						case 62:	$fee = 454.70;	break;
						case 63:	$fee = 462.10;	break;
						case 64:	$fee = 469.40;	break;
						case 65:	$fee = 476.70;	break;
						case 66:	$fee = 484.10;	break;
						case 67:	$fee = 491.40;	break;
						case 68:	$fee = 498.70;	break;
						case 69:	$fee = 506.10;	break;
						case 70:	$fee = 513.40;	break;
						case 71:	$fee = 520.70;	break;
						case 72:	$fee = 528.10;	break;
						case 73:	$fee = 535.40;	break;
						case 74:	$fee = 542.70;	break;
						case 75:	$fee = 550.10;	break;
						case 76:	$fee = 557.40;	break;
						case 77:	$fee = 564.70;	break;
						case 78:	$fee = 572.10;	break;
						case 79:	$fee = 579.40;	break;
						case 80:	$fee = 586.70;	break;
						case 81:	$fee = 594.10;	break;
						case 82:	$fee = 601.40;	break;
						case 83:	$fee = 608.70;	break;
						case 84:	$fee = 616.10;	break;
						case 85:	$fee = 623.40;	break;
						case 86:	$fee = 630.70;	break;
						case 87:	$fee = 638.10;	break;
						case 88:	$fee = 645.40;	break;
						case 89:	$fee = 652.70;	break;
						case 90:	$fee = 660.10;	break;
						case 91:	$fee = 667.40;	break;
						case 92:	$fee = 674.80;	break;
						case 93:	$fee = 682.10;	break;
						case 94:	$fee = 689.40;	break;
						case 95:	$fee = 696.80;	break;
						case 96:	$fee = 704.10;	break;
						case 97:	$fee = 711.40;	break;
						case 98:	$fee = 718.80;	break;
						case 99:	$fee = 726.10;	break;
						case 100:	$fee = 733.40;	break;
						case 101:	$fee = 740.80;	break;
						case 102:	$fee = 748.10;	break;
						case 103:	$fee = 755.40;	break;
						case 104:	$fee = 762.80;	break;
						case 105:	$fee = 770.10;	break;
						case 106:	$fee = 777.40;	break;
						case 107:	$fee = 784.80;	break;
						case 108:	$fee = 792.10;	break;
						case 109:	$fee = 799.40;	break;
						case 110:	$fee = 806.80;	break;
						case 111:	$fee = 814.10;	break;
						case 112:	$fee = 821.40;	break;
						case 113:	$fee = 828.80;	break;
						case 114:	$fee = 836.10;	break;
						case 115:	$fee = 843.40;	break;
						case 116:	$fee = 850.80;	break;
						case 117:	$fee = 858.10;	break;
						case 118:	$fee = 865.40;	break;
						case 119:	$fee = 872.80;	break;
						case 120:	$fee = 880.10;	break;
						case 121:	$fee = 887.40;	break;
						case 122:	$fee = 894.80;	break;
						case 123:	$fee = 902.10;	break;
						case 124:	$fee = 909.40;	break;
						case 125:	$fee = 916.80;	break;
						case 126:	$fee = 924.10;	break;
						case 127:	$fee = 931.40;	break;
						case 128:	$fee = 938.80;	break;
						case 129:	$fee = 946.10;	break;
						case 130:	$fee = 953.40;	break;
						case 131:	$fee = 960.80;	break;
						case 132:	$fee = 968.10;	break;
						case 133:	$fee = 975.40;	break;
						case 134:	$fee = 982.80;	break;
						case 135:	$fee = 990.10;	break;
						case 136:	$fee = 997.40;	break;
						case 137:	$fee = 1004.80;	break;
						case 138:	$fee = 1012.10;	break;
						case 139:	$fee = 1019.40;	break;
						case 140:	$fee = 1026.80;	break;
						case 141:	$fee = 1034.10;	break;
						case 142:	$fee = 1041.40;	break;
						case 143:	$fee = 1048.80;	break;
						case 144:	$fee = 1056.10;	break;
						case 145:	$fee = 1063.40;	break;
						case 146:	$fee = 1070.80;	break;
						case 147:	$fee = 1078.10;	break;
						case 148:	$fee = 1085.40;	break;
						case 149:	$fee = 1092.80;	break;
						case 150:	$fee = 1100.10;	break;
						case 151:	$fee = 1107.40;	break;
						case 152:	$fee = 1114.80;	break;
						case 153:	$fee = 1122.10;	break;
						case 154:	$fee = 1129.40;	break;
						case 155:	$fee = 1136.80;	break;
						case 156:	$fee = 1144.10;	break;
						case 157:	$fee = 1151.40;	break;
						case 158:	$fee = 1158.80;	break;
						case 159:	$fee = 1166.10;	break;
						case 160:	$fee = 1173.40;	break;
						case 161:	$fee = 1180.80;	break;
						case 162:	$fee = 1188.10;	break;
						case 163:	$fee = 1195.40;	break;
						case 164:	$fee = 1202.80;	break;
						case 165:	$fee = 1210.10;	break;
						case 166:	$fee = 1217.40;	break;
						case 167:	$fee = 1224.80;	break;
						case 168:	$fee = 1232.10;	break;
						case 169:	$fee = 1239.40;	break;
						case 170:	$fee = 1246.80;	break;
						case 171:	$fee = 1254.10;	break;
						case 172:	$fee = 1261.40;	break;
						case 173:	$fee = 1268.80;	break;
						case 174:	$fee = 1276.10;	break;
						case 175:	$fee = 1283.40;	break;
						case 176:	$fee = 1290.80;	break;
						case 177:	$fee = 1298.10;	break;
						case 178:	$fee = 1305.40;	break;
						case 179:	$fee = 1312.80;	break;
						case 180:	$fee = 1320.10;	break;
						case 181:	$fee = 1327.40;	break;
						case 182:	$fee = 1334.80;	break;
						case 183:	$fee = 1342.10;	break;
						case 184:	$fee = 1349.50;	break;
						case 185:	$fee = 1356.80;	break;
						case 186:	$fee = 1364.10;	break;
						case 187:	$fee = 1371.50;	break;
						case 188:	$fee = 1378.80;	break;
						case 189:	$fee = 1386.10;	break;
						case 190:	$fee = 1393.50;	break;
						case 191:	$fee = 1400.80;	break;
						case 192:	$fee = 1408.10;	break;
						case 193:	$fee = 1415.50;	break;
						case 194:	$fee = 1422.80;	break;
						case 195:	$fee = 1430.10;	break;
						case 196:	$fee = 1437.50;	break;
						case 197:	$fee = 1444.80;	break;
						case 198:	$fee = 1452.10;	break;
						case 199:	$fee = 1459.50;	break;
						case 200:	$fee = 1466.80;	break;
						case 201:	$fee = 1474.10;	break;
						case 202:	$fee = 1481.50;	break;
						case 203:	$fee = 1488.80;	break;
						case 204:	$fee = 1496.10;	break;
						case 205:	$fee = 1503.50;	break;
						case 206:	$fee = 1510.80;	break;
						case 207:	$fee = 1518.10;	break;
						case 208:	$fee = 1525.50;	break;
						case 209:	$fee = 1532.80;	break;
						case 210:	$fee = 1540.10;	break;
						case 211:	$fee = 1547.50;	break;
						case 212:	$fee = 1554.80;	break;
						case 213:	$fee = 1562.10;	break;
						case 214:	$fee = 1569.50;	break;
						case 215:	$fee = 1576.80;	break;
						case 216:	$fee = 1584.10;	break;
						case 217:	$fee = 1591.50;	break;
						case 1900-08-05:	$fee = 1598.80;	break;
						case 219:	$fee = 1606.10;	break;
						case 1900-08-07:	$fee = 1613.50;	break;
						case 1900-08-08:	$fee = 1620.80;	break;
						case 1900-08-09:	$fee = 1628.10;	break;
						case 1900-08-10:	$fee = 1635.50;	break;
						case 1900-08-11:	$fee = 1642.80;	break;
						case 1900-08-12:	$fee = 1650.10;	break;
						case 1900-08-13:	$fee = 1657.50;	break;
						case 1900-08-14:	$fee = 1664.80;	break;
						case 1900-08-15:	$fee = 1672.10;	break;
						case 1900-08-16:	$fee = 1679.50;	break;
						case 1900-08-17:	$fee = 1686.80;	break;
						case 1900-08-18:	$fee = 1694.10;	break;
						case 1900-08-19:	$fee = 1701.50;	break;
						case 1900-08-20:	$fee = 1708.80;	break;
						case 1900-08-21:	$fee = 1716.10;	break;
						case 1900-08-22:	$fee = 1723.50;	break;
						case 1900-08-23:	$fee = 1730.80;	break;
						case 1900-08-24:	$fee = 1738.10;	break;
						case 1900-08-25:	$fee = 1745.50;	break;
						case 1900-08-26:	$fee = 1752.80;	break;
						case 1900-08-27:	$fee = 1760.10;	break;
						case 1900-08-28:	$fee = 1767.50;	break;
						case 1900-08-29:	$fee = 1774.80;	break;
						case 1900-08-30:	$fee = 1782.10;	break;
						case 1900-08-31:	$fee = 1789.50;	break;
						case 1900-09-01:	$fee = 1796.80;	break;
						case 1900-09-02:	$fee = 1804.10;	break;
						case 1900-09-03:	$fee = 1811.50;	break;
						case 1900-09-04:	$fee = 1818.80;	break;
						case 1900-09-05:	$fee = 1826.10;	break;
						case 1900-09-06:	$fee = 1833.50;	break;
						case 1900-09-07:	$fee = 1840.80;	break;
						case 1900-09-08:	$fee = 1848.10;	break;
						case 1900-09-09:	$fee = 1855.50;	break;
						case 1900-09-10:	$fee = 1862.80;	break;
						case 1900-09-11:	$fee = 1870.10;	break;
						case 1900-09-12:	$fee = 1877.50;	break;
						case 1900-09-13:	$fee = 1884.80;	break;
						case 1900-09-14:	$fee = 1892.10;	break;
						case 1900-09-15:	$fee = 1899.50;	break;
						case 1900-09-16:	$fee = 1906.80;	break;
						case 1900-09-17:	$fee = 1914.10;	break;
						case 1900-09-18:	$fee = 1921.50;	break;
						case 1900-09-19:	$fee = 1928.80;	break;
						case 1900-09-20:	$fee = 1936.10;	break;
						case 1900-09-21:	$fee = 1943.50;	break;
						case 1900-09-22:	$fee = 1950.80;	break;
						case 1900-09-23:	$fee = 1958.10;	break;
						case 1900-09-24:	$fee = 1965.50;	break;
						case 1900-09-25:	$fee = 1972.80;	break;
						case 1900-09-26:	$fee = 1980.10;	break;
						case 1900-09-27:	$fee = 1987.50;	break;
						case 1900-09-28:	$fee = 1994.80;	break;
						case 273:	$fee = 2002.20;	break;
						case 274:	$fee = 2009.50;	break;
						case 275:	$fee = 2016.80;	break;
						case 276:	$fee = 2024.20;	break;
						case 277:	$fee = 2031.50;	break;
						case 278:	$fee = 2038.80;	break;
						case 279:	$fee = 2046.20;	break;
						case 280:	$fee = 2053.50;	break;
						case 281:	$fee = 2060.80;	break;
						case 282:	$fee = 2068.20;	break;
						case 283:	$fee = 2075.50;	break;
						case 284:	$fee = 2082.80;	break;
						case 285:	$fee = 2090.20;	break;
						case 286:	$fee = 2097.50;	break;
						case 287:	$fee = 2104.80;	break;
						case 288:	$fee = 2112.20;	break;
						case 289:	$fee = 2119.50;	break;
						case 290:	$fee = 2126.80;	break;
						case 291:	$fee = 2134.20;	break;
						case 292:	$fee = 2141.50;	break;
						case 293:	$fee = 2148.80;	break;
						case 294:	$fee = 2156.20;	break;
						case 295:	$fee = 2163.50;	break;
						case 296:	$fee = 2170.80;	break;
						case 297:	$fee = 2178.20;	break;
						case 298:	$fee = 2185.50;	break;
						case 299:	$fee = 2192.80;	break;
						case 300:	$fee = 2200.20;	break;
						case 301:	$fee = 2207.50;	break;
						case 302:	$fee = 2214.80;	break;
						case 303:	$fee = 2222.20;	break;
						case 304:	$fee = 2229.50;	break;
						case 305:	$fee = 2236.80;	break;
						case 306:	$fee = 2244.20;	break;
						case 307:	$fee = 2251.50;	break;
						case 308:	$fee = 2258.80;	break;
						case 309:	$fee = 2266.20;	break;
						case 310:	$fee = 2273.50;	break;
						case 311:	$fee = 2280.80;	break;
						case 312:	$fee = 2288.20;	break;
						case 313:	$fee = 2295.50;	break;
						case 314:	$fee = 2302.80;	break;
						case 315:	$fee = 2310.20;	break;
						case 316:	$fee = 2317.50;	break;
						case 317:	$fee = 2324.80;	break;
						case 318:	$fee = 2332.20;	break;
						case 319:	$fee = 2339.50;	break;
						case 320:	$fee = 2346.80;	break;
						case 321:	$fee = 2354.20;	break;
						case 322:	$fee = 2361.50;	break;
						case 323:	$fee = 2368.80;	break;
						case 324:	$fee = 2376.20;	break;
						case 325:	$fee = 2383.50;	break;
						case 326:	$fee = 2390.80;	break;
						case 327:	$fee = 2398.20;	break;
						case 328:	$fee = 2405.50;	break;
						case 329:	$fee = 2412.80;	break;
						case 330:	$fee = 2420.20;	break;
						case 331:	$fee = 2427.50;	break;
						case 332:	$fee = 2434.80;	break;
						case 333:	$fee = 2442.20;	break;
						case 334:	$fee = 2449.50;	break;
						case 335:	$fee = 2456.80;	break;
						case 336:	$fee = 2464.20;	break;
						case 337:	$fee = 2471.50;	break;
						case 338:	$fee = 2478.80;	break;
						case 339:	$fee = 2486.20;	break;
						case 340:	$fee = 2493.50;	break;
						case 341:	$fee = 2500.80;	break;
						case 342:	$fee = 2508.20;	break;
						case 343:	$fee = 2515.50;	break;
						case 344:	$fee = 2522.80;	break;
						case 345:	$fee = 2530.20;	break;
						case 346:	$fee = 2537.50;	break;
						case 347:	$fee = 2544.80;	break;
						case 348:	$fee = 2552.20;	break;
						case 349:	$fee = 2559.50;	break;
						case 350:	$fee = 2566.80;	break;
						case 351:	$fee = 2574.20;	break;
						case 352:	$fee = 2581.50;	break;
						case 353:	$fee = 2588.80;	break;
						case 354:	$fee = 2596.20;	break;
						case 355:	$fee = 2603.50;	break;
						case 356:	$fee = 2610.80;	break;
						case 357:	$fee = 2618.20;	break;
						case 358:	$fee = 2625.50;	break;
						case 359:	$fee = 2632.80;	break;
						case 360:	$fee = 2640.20;	break;
						case 361:	$fee = 2647.50;	break;
						case 362:	$fee = 2654.80;	break;
						case 363:	$fee = 2662.20;	break;
						case 364:	$fee = 2669.50;	break;
						case 365:	$fee = 2676.90;	break;
						case 366:	$fee = 2684.20;	break;
						case 367:	$fee = 2691.50;	break;
						case 368:	$fee = 2698.90;	break;
						case 369:	$fee = 2706.20;	break;
						case 370:	$fee = 2713.50;	break;
						case 371:	$fee = 2720.90;	break;
						case 372:	$fee = 2728.20;	break;
						case 373:	$fee = 2735.50;	break;
						case 374:	$fee = 2742.90;	break;
						case 375:	$fee = 2750.20;	break;
						case 376:	$fee = 2757.50;	break;
						case 377:	$fee = 2764.90;	break;
						case 378:	$fee = 2772.20;	break;
						case 379:	$fee = 2779.50;	break;
						case 380:	$fee = 2786.90;	break;
						case 381:	$fee = 2794.20;	break;
						case 382:	$fee = 2801.50;	break;
						case 383:	$fee = 2808.90;	break;
						case 384:	$fee = 2816.20;	break;
						case 385:	$fee = 2823.50;	break;
						case 386:	$fee = 2830.90;	break;
						case 387:	$fee = 2838.20;	break;
						case 388:	$fee = 2845.50;	break;
						case 389:	$fee = 2852.90;	break;
						case 390:	$fee = 2860.20;	break;
						case 391:	$fee = 2867.50;	break;
						case 392:	$fee = 2874.90;	break;
						case 393:	$fee = 2882.20;	break;
						case 394:	$fee = 2889.50;	break;
						case 395:	$fee = 2896.90;	break;
						case 396:	$fee = 2904.20;	break;
						case 397:	$fee = 2911.50;	break;
						case 398:	$fee = 2918.90;	break;
						case 399:	$fee = 2926.20;	break;
						case 400:	$fee = 2933.50;	break;
						case 401:	$fee = 2940.90;	break;
						case 402:	$fee = 2948.20;	break;
						case 403:	$fee = 2955.50;	break;
						case 404:	$fee = 2962.90;	break;
						case 405:	$fee = 2970.20;	break;
						case 406:	$fee = 2977.50;	break;
						case 407:	$fee = 2984.90;	break;
						case 408:	$fee = 2992.20;	break;
						case 409:	$fee = 2999.50;	break;
						case 410:	$fee = 3006.90;	break;
						case 411:	$fee = 3014.20;	break;
						case 412:	$fee = 3021.50;	break;
						case 413:	$fee = 3028.90;	break;
						case 414:	$fee = 3036.20;	break;
						case 415:	$fee = 3043.50;	break;
						case 416:	$fee = 3050.90;	break;
						case 417:	$fee = 3058.20;	break;
						case 418:	$fee = 3065.50;	break;
						case 419:	$fee = 3072.90;	break;
						case 420:	$fee = 3080.20;	break;
						case 421:	$fee = 3087.50;	break;
						case 422:	$fee = 3094.90;	break;
						case 423:	$fee = 3102.20;	break;
						case 424:	$fee = 3109.50;	break;
						case 425:	$fee = 3116.90;	break;
						case 426:	$fee = 3124.20;	break;
						case 427:	$fee = 3131.50;	break;
						case 428:	$fee = 3138.90;	break;
						case 429:	$fee = 3146.20;	break;
						case 430:	$fee = 3153.50;	break;
						case 431:	$fee = 3160.90;	break;
						case 432:	$fee = 3168.20;	break;
						case 433:	$fee = 3175.50;	break;
						case 434:	$fee = 3182.90;	break;
						case 435:	$fee = 3190.20;	break;
						case 436:	$fee = 3197.50;	break;
						case 437:	$fee = 3204.90;	break;
						case 438:	$fee = 3212.20;	break;
						case 439:	$fee = 3219.50;	break;
						case 440:	$fee = 3226.90;	break;
						case 441:	$fee = 3234.20;	break;
						case 442:	$fee = 3241.50;	break;
						case 443:	$fee = 3248.90;	break;
						case 444:	$fee = 3256.20;	break;
						case 445:	$fee = 3263.50;	break;
						case 446:	$fee = 3270.90;	break;
						case 447:	$fee = 3278.20;	break;
						case 448:	$fee = 3285.50;	break;
						case 449:	$fee = 3292.90;	break;
						case 450:	$fee = 3300.20;	break;
						case 451:	$fee = 3307.50;	break;
						case 452:	$fee = 3314.90;	break;
						case 453:	$fee = 3322.20;	break;
						case 454:	$fee = 3329.50;	break;
						case 455:	$fee = 3336.90;	break;
						case 456:	$fee = 3344.20;	break;
						case 457:	$fee = 3351.60;	break;
						case 458:	$fee = 3358.90;	break;
						case 459:	$fee = 3366.20;	break;
						case 460:	$fee = 3373.60;	break;
						case 461:	$fee = 3380.90;	break;
						case 462:	$fee = 3388.20;	break;
						case 463:	$fee = 3395.60;	break;
						case 464:	$fee = 3402.90;	break;
						case 465:	$fee = 3410.20;	break;
						case 466:	$fee = 3417.60;	break;
						case 467:	$fee = 3424.90;	break;
						case 468:	$fee = 3432.20;	break;
						case 469:	$fee = 3439.60;	break;
						case 470:	$fee = 3446.90;	break;
						case 471:	$fee = 3454.20;	break;
						case 472:	$fee = 3461.60;	break;
						case 473:	$fee = 3468.90;	break;
						case 474:	$fee = 3476.20;	break;
						case 475:	$fee = 3483.60;	break;
						case 476:	$fee = 3490.90;	break;
						case 477:	$fee = 3498.20;	break;
						case 478:	$fee = 3505.60;	break;
						case 479:	$fee = 3512.90;	break;
						case 480:	$fee = 3520.20;	break;
						case 481:	$fee = 3527.60;	break;
						case 482:	$fee = 3534.90;	break;
						case 483:	$fee = 3542.20;	break;
						case 484:	$fee = 3549.60;	break;
						case 485:	$fee = 3556.90;	break;
						case 486:	$fee = 3564.20;	break;
						case 487:	$fee = 3571.60;	break;
						case 488:	$fee = 3578.90;	break;
						case 489:	$fee = 3586.20;	break;
						case 490:	$fee = 3593.60;	break;
						case 491:	$fee = 3600.90;	break;
						case 492:	$fee = 3608.20;	break;
						case 493:	$fee = 3615.60;	break;
						case 494:	$fee = 3622.90;	break;
						case 495:	$fee = 3630.20;	break;
						case 496:	$fee = 3637.60;	break;
						case 497:	$fee = 3644.90;	break;
						case 498:	$fee = 3652.20;	break;
						case 499:	$fee = 3659.60;	break;
						case 500:	$fee = 3666.90;	break;
						case 501:	$fee = 3674.20;	break;
						case 502:	$fee = 3681.60;	break;
						case 503:	$fee = 3688.90;	break;
						case 504:	$fee = 3696.20;	break;
						case 505:	$fee = 3703.60;	break;
						case 506:	$fee = 3710.90;	break;
						case 507:	$fee = 3718.20;	break;
						case 508:	$fee = 3725.60;	break;
						case 509:	$fee = 3732.90;	break;
						case 510:	$fee = 3740.20;	break;
						case 511:	$fee = 3747.60;	break;
						case 512:	$fee = 3754.90;	break;
						case 513:	$fee = 3762.20;	break;
						case 514:	$fee = 3769.60;	break;
						case 515:	$fee = 3776.90;	break;
						case 516:	$fee = 3784.20;	break;
						case 517:	$fee = 3791.60;	break;
						case 518:	$fee = 3798.90;	break;
						case 519:	$fee = 3806.20;	break;
						case 520:	$fee = 3813.60;	break;
						case 521:	$fee = 3820.90;	break;
						case 522:	$fee = 3828.20;	break;
						case 523:	$fee = 3835.60;	break;
						case 524:	$fee = 3842.90;	break;
						case 525:	$fee = 3850.20;	break;
						case 526:	$fee = 3857.60;	break;
						case 527:	$fee = 3864.90;	break;
						case 528:	$fee = 3872.20;	break;
						case 529:	$fee = 3879.60;	break;
						case 530:	$fee = 3886.90;	break;
						case 531:	$fee = 3894.20;	break;
						case 532:	$fee = 3901.60;	break;
						case 533:	$fee = 3908.90;	break;
						case 534:	$fee = 3916.20;	break;
						case 535:	$fee = 3923.60;	break;
						case 536:	$fee = 3930.90;	break;
						case 537:	$fee = 3938.20;	break;
						case 538:	$fee = 3945.60;	break;
						case 539:	$fee = 3952.90;	break;
						case 540:	$fee = 3960.20;	break;
						case 541:	$fee = 3967.60;	break;
						case 542:	$fee = 3974.90;	break;
						case 543:	$fee = 3982.20;	break;
						case 544:	$fee = 3989.60;	break;
						case 545:	$fee = 3996.90;	break;
						case 546:	$fee = 4004.30;	break;
						case 547:	$fee = 4011.60;	break;
						case 548:	$fee = 4018.90;	break;
						case 549:	$fee = 4026.30;	break;
						case 550:	$fee = 4033.60;	break;
						case 551:	$fee = 4040.90;	break;
						case 552:	$fee = 4048.30;	break;
						case 553:	$fee = 4055.60;	break;
						case 554:	$fee = 4062.90;	break;
						case 555:	$fee = 4070.30;	break;
						case 556:	$fee = 4077.60;	break;
						case 557:	$fee = 4084.90;	break;
						case 558:	$fee = 4092.30;	break;
						case 559:	$fee = 4099.60;	break;
						case 560:	$fee = 4106.90;	break;
						case 561:	$fee = 4114.30;	break;
						case 562:	$fee = 4121.60;	break;
						case 563:	$fee = 4128.90;	break;
						case 564:	$fee = 4136.30;	break;
						case 565:	$fee = 4143.60;	break;
						case 566:	$fee = 4150.90;	break;
						case 567:	$fee = 4158.30;	break;
						case 568:	$fee = 4165.60;	break;
						case 569:	$fee = 4172.90;	break;
						case 570:	$fee = 4180.30;	break;
						case 571:	$fee = 4187.60;	break;
						case 572:	$fee = 4194.90;	break;
						case 573:	$fee = 4202.30;	break;
						case 574:	$fee = 4209.60;	break;
						case 575:	$fee = 4216.90;	break;
						case 576:	$fee = 4224.30;	break;
						case 577:	$fee = 4231.60;	break;
						case 578:	$fee = 4238.90;	break;
						case 579:	$fee = 4246.30;	break;
						case 580:	$fee = 4253.60;	break;
						case 581:	$fee = 4260.90;	break;
						case 582:	$fee = 4268.30;	break;
						case 583:	$fee = 4275.60;	break;
						case 584:	$fee = 4282.90;	break;
						case 585:	$fee = 4290.30;	break;
						case 586:	$fee = 4297.60;	break;
						case 587:	$fee = 4304.90;	break;
						case 588:	$fee = 4312.30;	break;
						case 589:	$fee = 4319.60;	break;
						case 590:	$fee = 4326.90;	break;
						case 591:	$fee = 4334.30;	break;
						case 592:	$fee = 4341.60;	break;
						case 593:	$fee = 4348.90;	break;
						case 594:	$fee = 4356.30;	break;
						case 595:	$fee = 4363.60;	break;
						case 596:	$fee = 4370.90;	break;
						case 597:	$fee = 4378.30;	break;
						case 598:	$fee = 4385.60;	break;
						case 599:	$fee = 4392.90;	break;
						case 600:	$fee = 4400.30;	break;
						case 601:	$fee = 4407.60;	break;
						case 602:	$fee = 4414.90;	break;
						case 603:	$fee = 4422.30;	break;
						case 604:	$fee = 4429.60;	break;
						case 605:	$fee = 4436.90;	break;
						case 606:	$fee = 4444.30;	break;
						case 607:	$fee = 4451.60;	break;
						case 608:	$fee = 4458.90;	break;
						case 609:	$fee = 4466.30;	break;
						case 610:	$fee = 4473.60;	break;
						case 611:	$fee = 4480.90;	break;
						case 612:	$fee = 4488.30;	break;
						case 613:	$fee = 4495.60;	break;
						case 614:	$fee = 4502.90;	break;
						case 615:	$fee = 4510.30;	break;
						case 616:	$fee = 4517.60;	break;
						case 617:	$fee = 4524.90;	break;
						case 618:	$fee = 4532.30;	break;
						case 619:	$fee = 4539.60;	break;
						case 620:	$fee = 4546.90;	break;
						case 621:	$fee = 4554.30;	break;
						case 622:	$fee = 4561.60;	break;
						case 623:	$fee = 4568.90;	break;
						case 624:	$fee = 4576.30;	break;
						case 625:	$fee = 4583.60;	break;
						case 626:	$fee = 4590.90;	break;
						case 627:	$fee = 4598.30;	break;
						case 628:	$fee = 4605.60;	break;
						case 629:	$fee = 4612.90;	break;
						case 630:	$fee = 4620.30;	break;
						case 631:	$fee = 4627.60;	break;
						case 632:	$fee = 4634.90;	break;
						case 633:	$fee = 4642.30;	break;
						case 634:	$fee = 4649.60;	break;
						case 635:	$fee = 4656.90;	break;
						case 636:	$fee = 4664.30;	break;
						case 637:	$fee = 4671.60;	break;
						case 638:	$fee = 4679.00;	break;
						case 639:	$fee = 4686.30;	break;
						case 640:	$fee = 4693.60;	break;
						case 641:	$fee = 4701.00;	break;
						case 642:	$fee = 4708.30;	break;
						case 643:	$fee = 4715.60;	break;
						case 644:	$fee = 4723.00;	break;
						case 645:	$fee = 4730.30;	break;
						case 646:	$fee = 4737.60;	break;
						case 647:	$fee = 4745.00;	break;
						case 648:	$fee = 4752.30;	break;
						case 649:	$fee = 4759.60;	break;
						case 650:	$fee = 4767.00;	break;
						case 651:	$fee = 4774.30;	break;
						case 652:	$fee = 4781.60;	break;
						case 653:	$fee = 4789.00;	break;
						case 654:	$fee = 4796.30;	break;
						case 655:	$fee = 4803.60;	break;
						case 656:	$fee = 4811.00;	break;
						case 657:	$fee = 4818.30;	break;
						case 658:	$fee = 4825.60;	break;
						case 659:	$fee = 4833.00;	break;
						case 660:	$fee = 4840.30;	break;
						case 661:	$fee = 4847.60;	break;
						case 662:	$fee = 4855.00;	break;
						case 663:	$fee = 4862.30;	break;
						case 664:	$fee = 4869.60;	break;
						case 665:	$fee = 4877.00;	break;
						case 666:	$fee = 4884.30;	break;
						case 667:	$fee = 4891.60;	break;
						case 668:	$fee = 4899.00;	break;
						case 669:	$fee = 4906.30;	break;
						case 670:	$fee = 4913.60;	break;
						case 671:	$fee = 4921.00;	break;
						case 672:	$fee = 4928.30;	break;
						case 673:	$fee = 4935.60;	break;
						case 674:	$fee = 4943.00;	break;
						case 675:	$fee = 4950.30;	break;
						case 676:	$fee = 4957.60;	break;
						case 677:	$fee = 4965.00;	break;
						case 678:	$fee = 4972.30;	break;
						case 679:	$fee = 4979.60;	break;
						case 680:	$fee = 4987.00;	break;
						case 681:	$fee = 4994.30;	break;
						case 682:	$fee = 5001.60;	break;
						case 683:	$fee = 5009.00;	break;
						case 684:	$fee = 5016.30;	break;
						case 685:	$fee = 5023.60;	break;
						case 686:	$fee = 5031.00;	break;
						case 687:	$fee = 5038.30;	break;
						case 688:	$fee = 5045.60;	break;
						case 689:	$fee = 5053.00;	break;
						case 690:	$fee = 5060.30;	break;
						case 691:	$fee = 5067.60;	break;
						case 692:	$fee = 5075.00;	break;
						case 693:	$fee = 5082.30;	break;
						case 694:	$fee = 5089.60;	break;
						case 695:	$fee = 5097.00;	break;
						case 696:	$fee = 5104.30;	break;
						case 697:	$fee = 5111.60;	break;
						case 698:	$fee = 5119.00;	break;
						case 699:	$fee = 5126.30;	break;
						case 700:	$fee = 5133.60;	break;
						case 701:	$fee = 5141.00;	break;
						case 702:	$fee = 5148.30;	break;
						case 703:	$fee = 5155.60;	break;
						case 704:	$fee = 5163.00;	break;
						case 705:	$fee = 5170.30;	break;
						case 706:	$fee = 5177.60;	break;
						case 707:	$fee = 5185.00;	break;
						case 708:	$fee = 5192.30;	break;
						case 709:	$fee = 5199.60;	break;
						case 710:	$fee = 5207.00;	break;
						case 711:	$fee = 5214.30;	break;
						case 712:	$fee = 5221.60;	break;
						case 713:	$fee = 5229.00;	break;
						case 714:	$fee = 5236.30;	break;
						case 715:	$fee = 5243.60;	break;
						case 716:	$fee = 5251.00;	break;
						case 717:	$fee = 5258.30;	break;
						case 718:	$fee = 5265.60;	break;
						case 719:	$fee = 5273.00;	break;
						case 720:	$fee = 5280.30;	break;
						case 721:	$fee = 5287.60;	break;
						case 722:	$fee = 5295.00;	break;
						case 723:	$fee = 5302.30;	break;
						case 724:	$fee = 5309.60;	break;
						case 725:	$fee = 5317.00;	break;
						case 726:	$fee = 5324.30;	break;
						case 727:	$fee = 5331.60;	break;
						case 728:	$fee = 5339.00;	break;
						case 729:	$fee = 5346.30;	break;
						case 730:	$fee = 5353.70;	break;
						case 731:	$fee = 5361.00;	break;
						case 732:	$fee = 5368.30;	break;
						case 733:	$fee = 5375.70;	break;
						case 734:	$fee = 5383.00;	break;
						case 735:	$fee = 5390.30;	break;
						case 736:	$fee = 5397.70;	break;
						case 737:	$fee = 5405.00;	break;
						case 738:	$fee = 5412.30;	break;
						case 739:	$fee = 5419.70;	break;
						case 740:	$fee = 5427.00;	break;
						case 741:	$fee = 5434.30;	break;
						case 742:	$fee = 5441.70;	break;
						case 743:	$fee = 5449.00;	break;
						case 744:	$fee = 5456.30;	break;
						case 745:	$fee = 5463.70;	break;
						case 746:	$fee = 5471.00;	break;
						case 747:	$fee = 5478.30;	break;
						case 748:	$fee = 5485.70;	break;
						case 749:	$fee = 5493.00;	break;
						case 750:	$fee = 5500.30;	break;
						case 751:	$fee = 5507.70;	break;
						case 752:	$fee = 5515.00;	break;
						case 753:	$fee = 5522.30;	break;
						case 754:	$fee = 5529.70;	break;
						case 755:	$fee = 5537.00;	break;
						case 756:	$fee = 5544.30;	break;
						case 757:	$fee = 5551.70;	break;
						case 758:	$fee = 5559.00;	break;
						case 759:	$fee = 5566.30;	break;
						case 760:	$fee = 5573.70;	break;
						case 761:	$fee = 5581.00;	break;
						case 762:	$fee = 5588.30;	break;
						case 763:	$fee = 5595.70;	break;
						case 764:	$fee = 5603.00;	break;
						case 765:	$fee = 5610.30;	break;
						case 766:	$fee = 5617.70;	break;
						case 767:	$fee = 5625.00;	break;
						case 768:	$fee = 5632.30;	break;
						case 769:	$fee = 5639.70;	break;
						case 770:	$fee = 5647.00;	break;
						case 771:	$fee = 5654.30;	break;
						case 772:	$fee = 5661.70;	break;
						case 773:	$fee = 5669.00;	break;
						case 774:	$fee = 5676.30;	break;
						case 775:	$fee = 5683.70;	break;
						case 776:	$fee = 5691.00;	break;
						case 777:	$fee = 5698.30;	break;
						case 778:	$fee = 5705.70;	break;
						case 779:	$fee = 5713.00;	break;
						case 780:	$fee = 5720.30;	break;
						case 781:	$fee = 5727.70;	break;
						case 782:	$fee = 5735.00;	break;
						case 783:	$fee = 5742.30;	break;
						case 784:	$fee = 5749.70;	break;
						case 785:	$fee = 5757.00;	break;
						case 786:	$fee = 5764.30;	break;
						case 787:	$fee = 5771.70;	break;
						case 788:	$fee = 5779.00;	break;
						case 789:	$fee = 5786.30;	break;
						case 790:	$fee = 5793.70;	break;
						case 791:	$fee = 5801.00;	break;
						case 792:	$fee = 5808.30;	break;
						case 793:	$fee = 5815.70;	break;
						case 794:	$fee = 5823.00;	break;
						case 795:	$fee = 5830.30;	break;
						case 796:	$fee = 5837.70;	break;
						case 797:	$fee = 5845.00;	break;
						case 798:	$fee = 5852.30;	break;
						case 799:	$fee = 5859.70;	break;
						case 800:	$fee = 5867.00;	break;
						case 801:	$fee = 5874.30;	break;
						case 802:	$fee = 5881.70;	break;
						case 803:	$fee = 5889.00;	break;
						case 804:	$fee = 5896.30;	break;
						case 805:	$fee = 5903.70;	break;
						case 806:	$fee = 5911.00;	break;
						case 807:	$fee = 5918.30;	break;
						case 808:	$fee = 5925.70;	break;
						case 809:	$fee = 5933.00;	break;
						case 810:	$fee = 5940.30;	break;
						case 811:	$fee = 5947.70;	break;
						case 812:	$fee = 5955.00;	break;
						case 813:	$fee = 5962.30;	break;
						case 814:	$fee = 5969.70;	break;
						case 815:	$fee = 5977.00;	break;
						case 816:	$fee = 5984.30;	break;
						case 817:	$fee = 5991.70;	break;
						case 818:	$fee = 5999.00;	break;
						case 819:	$fee = 6006.40;	break;
						case 820:	$fee = 6013.70;	break;
						case 821:	$fee = 6021.00;	break;
						case 822:	$fee = 6028.40;	break;
						case 823:	$fee = 6035.70;	break;
						case 824:	$fee = 6043.00;	break;
						case 825:	$fee = 6050.40;	break;
						case 826:	$fee = 6057.70;	break;
						case 827:	$fee = 6065.00;	break;
						case 828:	$fee = 6072.40;	break;
						case 829:	$fee = 6079.70;	break;
						case 830:	$fee = 6087.00;	break;
						case 831:	$fee = 6094.40;	break;
						case 832:	$fee = 6101.70;	break;
						case 833:	$fee = 6109.00;	break;
						case 834:	$fee = 6116.40;	break;
						case 835:	$fee = 6123.70;	break;
						case 836:	$fee = 6131.00;	break;
						case 837:	$fee = 6138.40;	break;
						case 838:	$fee = 6145.70;	break;
						case 839:	$fee = 6153.00;	break;
						case 840:	$fee = 6160.40;	break;
						case 841:	$fee = 6167.70;	break;
						case 842:	$fee = 6175.00;	break;
						case 843:	$fee = 6182.40;	break;
						case 844:	$fee = 6189.70;	break;
						case 845:	$fee = 6197.00;	break;
						case 846:	$fee = 6204.40;	break;
						case 847:	$fee = 6211.70;	break;
						case 848:	$fee = 6219.00;	break;
						case 849:	$fee = 6226.40;	break;
						case 850:	$fee = 6233.70;	break;
						case 851:	$fee = 6241.00;	break;
						case 852:	$fee = 6248.40;	break;
						case 853:	$fee = 6255.70;	break;
						case 854:	$fee = 6263.00;	break;
						case 855:	$fee = 6270.40;	break;
						case 856:	$fee = 6277.70;	break;
						case 857:	$fee = 6285.00;	break;
						case 858:	$fee = 6292.40;	break;
						case 859:	$fee = 6299.70;	break;
						case 860:	$fee = 6307.00;	break;
						case 861:	$fee = 6314.40;	break;
						case 862:	$fee = 6321.70;	break;
						case 863:	$fee = 6329.00;	break;
						case 864:	$fee = 6336.40;	break;
						case 865:	$fee = 6343.70;	break;
						case 866:	$fee = 6351.00;	break;
						case 867:	$fee = 6358.40;	break;
						case 868:	$fee = 6365.70;	break;
						case 869:	$fee = 6373.00;	break;
						case 870:	$fee = 6380.40;	break;
						case 871:	$fee = 6387.70;	break;
						case 872:	$fee = 6395.00;	break;
						case 873:	$fee = 6402.40;	break;
						case 874:	$fee = 6409.70;	break;
						case 875:	$fee = 6417.00;	break;
						case 876:	$fee = 6424.40;	break;
						case 877:	$fee = 6431.70;	break;
						case 878:	$fee = 6439.00;	break;
						case 879:	$fee = 6446.40;	break;
						case 880:	$fee = 6453.70;	break;
						case 881:	$fee = 6461.00;	break;
						case 882:	$fee = 6468.40;	break;
						case 883:	$fee = 6475.70;	break;
						case 884:	$fee = 6483.00;	break;
						case 885:	$fee = 6490.40;	break;
						case 886:	$fee = 6497.70;	break;
						case 887:	$fee = 6505.00;	break;
						case 888:	$fee = 6512.40;	break;
						case 889:	$fee = 6519.70;	break;
						case 890:	$fee = 6527.00;	break;
						case 891:	$fee = 6534.40;	break;
						case 892:	$fee = 6541.70;	break;
						case 893:	$fee = 6549.00;	break;
						case 894:	$fee = 6556.40;	break;
						case 895:	$fee = 6563.70;	break;
						case 896:	$fee = 6571.00;	break;
						case 897:	$fee = 6578.40;	break;
						case 898:	$fee = 6585.70;	break;
						case 899:	$fee = 6593.00;	break;
						case 900:	$fee = 6600.40;	break;
						case 901:	$fee = 6607.70;	break;
						case 902:	$fee = 6615.00;	break;
						case 903:	$fee = 6622.40;	break;
						case 904:	$fee = 6629.70;	break;
						case 905:	$fee = 6637.00;	break;
						case 906:	$fee = 6644.40;	break;
						case 907:	$fee = 6651.70;	break;
						case 908:	$fee = 6659.00;	break;
						case 909:	$fee = 6666.40;	break;
						case 910:	$fee = 6673.70;	break;
						case 911:	$fee = 6681.10;	break;
						case 912:	$fee = 6688.40;	break;
						case 913:	$fee = 6695.70;	break;
						case 914:	$fee = 6703.10;	break;
						case 915:	$fee = 6710.40;	break;
						case 916:	$fee = 6717.70;	break;
						case 917:	$fee = 6725.10;	break;
						case 918:	$fee = 6732.40;	break;
						case 919:	$fee = 6739.70;	break;
						case 920:	$fee = 6747.10;	break;
						case 921:	$fee = 6754.40;	break;
						case 922:	$fee = 6761.70;	break;
						case 923:	$fee = 6769.10;	break;
						case 924:	$fee = 6776.40;	break;
						case 925:	$fee = 6783.70;	break;
						case 926:	$fee = 6791.10;	break;
						case 927:	$fee = 6798.40;	break;
						case 928:	$fee = 6805.70;	break;
						case 929:	$fee = 6813.10;	break;
						case 930:	$fee = 6820.40;	break;
						case 931:	$fee = 6827.70;	break;
						case 932:	$fee = 6835.10;	break;
						case 933:	$fee = 6842.40;	break;
						case 934:	$fee = 6849.70;	break;
						case 935:	$fee = 6857.10;	break;
						case 936:	$fee = 6864.40;	break;
						case 937:	$fee = 6871.70;	break;
						case 938:	$fee = 6879.10;	break;
						case 939:	$fee = 6886.40;	break;
						case 940:	$fee = 6893.70;	break;
						case 941:	$fee = 6901.10;	break;
						case 942:	$fee = 6908.40;	break;
						case 943:	$fee = 6915.70;	break;
						case 944:	$fee = 6923.10;	break;
						case 945:	$fee = 6930.40;	break;
						case 946:	$fee = 6937.70;	break;
						case 947:	$fee = 6945.10;	break;
						case 948:	$fee = 6952.40;	break;
						case 949:	$fee = 6959.70;	break;
						case 950:	$fee = 6967.10;	break;
						case 951:	$fee = 6974.40;	break;
						case 952:	$fee = 6981.70;	break;
						case 953:	$fee = 6989.10;	break;
						case 954:	$fee = 6996.40;	break;
						case 955:	$fee = 7003.70;	break;
						case 956:	$fee = 7011.10;	break;
						case 957:	$fee = 7018.40;	break;
						case 958:	$fee = 7025.70;	break;
						case 959:	$fee = 7033.10;	break;
						case 960:	$fee = 7040.40;	break;
						case 961:	$fee = 7047.70;	break;
						case 962:	$fee = 7055.10;	break;
						case 963:	$fee = 7062.40;	break;
						case 964:	$fee = 7069.70;	break;
						case 965:	$fee = 7077.10;	break;
						case 966:	$fee = 7084.40;	break;
						case 967:	$fee = 7091.70;	break;
						case 968:	$fee = 7099.10;	break;
						case 969:	$fee = 7106.40;	break;
						case 970:	$fee = 7113.70;	break;
						case 971:	$fee = 7121.10;	break;
						case 972:	$fee = 7128.40;	break;
						case 973:	$fee = 7135.70;	break;
						case 974:	$fee = 7143.10;	break;
						case 975:	$fee = 7150.40;	break;
						case 976:	$fee = 7157.70;	break;
						case 977:	$fee = 7165.10;	break;
						case 978:	$fee = 7172.40;	break;
						case 979:	$fee = 7179.70;	break;
						case 980:	$fee = 7187.10;	break;
						case 981:	$fee = 7194.40;	break;
						case 982:	$fee = 7201.70;	break;
						case 983:	$fee = 7209.10;	break;
						case 984:	$fee = 7216.40;	break;
						case 985:	$fee = 7223.70;	break;
						case 986:	$fee = 7231.10;	break;
						case 987:	$fee = 7238.40;	break;
						case 988:	$fee = 7245.70;	break;
						case 989:	$fee = 7253.10;	break;
						case 990:	$fee = 7260.40;	break;
						case 991:	$fee = 7267.70;	break;
						case 992:	$fee = 7275.10;	break;
						case 993:	$fee = 7282.40;	break;
						case 994:	$fee = 7289.70;	break;
						case 995:	$fee = 7297.10;	break;
						case 996:	$fee = 7304.40;	break;
						case 997:	$fee = 7311.70;	break;
						case 998:	$fee = 7319.10;	break;
						case 999:	$fee = 7326.40;	break;
						case 1000:	$fee = 7333.70;	break;
						default:
							$fee = ceil(1.1 * $org_fee / 21);
							break;
					}

				break;
				default:
					$fee = ceil(1.1 * $org_fee / 21);
					break;
			}
		}

		return $fee;
	}

}
