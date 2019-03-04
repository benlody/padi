
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
					$fee = ceil($weight / 18) * 11;
				break;
				case 'Korea': 
					$fee = ceil((floor($weight/20)*1780 + ($weight%20)*80 + 180)*1.1/21 - 0.0001);
				break;
				case 'HongKong': 
					switch ($weight){
						case 1:	$fee = 6;	break;
						case 2:	$fee = 11.3;	break;
						case 3:	$fee = 16.3;	break;
						case 4:	$fee = 22;	break;
						case 5:	$fee = 27.7;	break;
						case 6:	$fee = 33.4;	break;
						case 7:	$fee = 39.1;	break;
						case 8:	$fee = 44.7;	break;
						case 9:	$fee = 50.4;	break;
						case 10:	$fee = 56.1;	break;
						case 11:	$fee = 61.8;	break;
						case 12:	$fee = 67.5;	break;
						case 13:	$fee = 73.2;	break;
						case 14:	$fee = 78.8;	break;
						case 15:	$fee = 84.5;	break;
						case 16:	$fee = 90.2;	break;
						case 17:	$fee = 95.9;	break;
						case 18:	$fee = 101.6;	break;
						case 19:	$fee = 107.2;	break;
						case 20:	$fee = 112.5;	break;
						case 21:	$fee = 118.1;	break;
						case 22:	$fee = 123.8;	break;
						case 23:	$fee = 129.4;	break;
						case 24:	$fee = 135;	break;
						case 25:	$fee = 140.6;	break;
						case 26:	$fee = 146.3;	break;
						case 27:	$fee = 151.9;	break;
						case 28:	$fee = 157.5;	break;
						case 29:	$fee = 163.1;	break;
						case 30:	$fee = 168.7;	break;
						case 31:	$fee = 174.4;	break;
						case 32:	$fee = 180;	break;
						case 33:	$fee = 185.6;	break;
						case 34:	$fee = 191.2;	break;
						case 35:	$fee = 196.9;	break;
						case 36:	$fee = 202.5;	break;
						case 37:	$fee = 208.1;	break;
						case 38:	$fee = 213.7;	break;
						case 39:	$fee = 219.4;	break;
						case 40:	$fee = 225;	break;
						case 41:	$fee = 230.6;	break;
						case 42:	$fee = 236.2;	break;
						case 43:	$fee = 241.8;	break;
						case 44:	$fee = 247.5;	break;
						case 45:	$fee = 253.1;	break;
						case 46:	$fee = 258.7;	break;
						case 47:	$fee = 264.3;	break;
						case 48:	$fee = 270;	break;
						case 49:	$fee = 275.6;	break;
						case 50:	$fee = 281.2;	break;
						case 51:	$fee = 286.8;	break;
						case 52:	$fee = 292.5;	break;
						case 53:	$fee = 298.1;	break;
						case 54:	$fee = 303.7;	break;
						case 55:	$fee = 309.3;	break;
						case 56:	$fee = 314.9;	break;
						case 57:	$fee = 320.6;	break;
						case 58:	$fee = 326.2;	break;
						case 59:	$fee = 331.8;	break;
						case 60:	$fee = 337.4;	break;
						case 61:	$fee = 343.1;	break;
						case 62:	$fee = 348.7;	break;
						case 63:	$fee = 354.3;	break;
						case 64:	$fee = 359.9;	break;
						case 65:	$fee = 365.6;	break;
						case 66:	$fee = 371.2;	break;
						case 67:	$fee = 376.8;	break;
						case 68:	$fee = 382.4;	break;
						case 69:	$fee = 388;	break;
						case 70:	$fee = 393.7;	break;
						case 71:	$fee = 399.3;	break;
						case 72:	$fee = 404.9;	break;
						case 73:	$fee = 410.5;	break;
						case 74:	$fee = 416.2;	break;
						case 75:	$fee = 421.8;	break;
						case 76:	$fee = 427.4;	break;
						case 77:	$fee = 433;	break;
						case 78:	$fee = 438.7;	break;
						case 79:	$fee = 444.3;	break;
						case 80:	$fee = 449.9;	break;
						case 81:	$fee = 455.5;	break;
						case 82:	$fee = 461.1;	break;
						case 83:	$fee = 466.8;	break;
						case 84:	$fee = 472.4;	break;
						case 85:	$fee = 478;	break;
						case 86:	$fee = 483.6;	break;
						case 87:	$fee = 489.3;	break;
						case 88:	$fee = 494.9;	break;
						case 89:	$fee = 500.5;	break;
						case 90:	$fee = 506.1;	break;
						case 91:	$fee = 511.8;	break;
						case 92:	$fee = 517.4;	break;
						case 93:	$fee = 523;	break;
						case 94:	$fee = 528.6;	break;
						case 95:	$fee = 534.2;	break;
						case 96:	$fee = 539.9;	break;
						case 97:	$fee = 545.5;	break;
						case 98:	$fee = 551.1;	break;
						case 99:	$fee = 556.7;	break;
						case 100:	$fee = 562.4;	break;
						default:
							$fee = ceil(1.1 * $org_fee / 21);
							break;
					}
				break;
				case 'Macau': 
					switch ($weight){
						case 1:	$fee = 7.4;	break;
						case 2:	$fee = 12.8;	break;
						case 3:	$fee = 18.4;	break;
						case 4:	$fee = 25.5;	break;
						case 5:	$fee = 32.6;	break;
						case 6:	$fee = 39.7;	break;
						case 7:	$fee = 46.8;	break;
						case 8:	$fee = 53.9;	break;
						case 9:	$fee = 61;	break;
						case 10:	$fee = 68.1;	break;
						case 11:	$fee = 75.2;	break;
						case 12:	$fee = 82.3;	break;
						case 13:	$fee = 89.4;	break;
						case 14:	$fee = 96.5;	break;
						case 15:	$fee = 103.6;	break;
						case 16:	$fee = 110.7;	break;
						case 17:	$fee = 117.8;	break;
						case 18:	$fee = 124.9;	break;
						case 19:	$fee = 132;	break;
						case 20:	$fee = 139.7;	break;
						case 21:	$fee = 146.7;	break;
						case 22:	$fee = 153.7;	break;
						case 23:	$fee = 160.7;	break;
						case 24:	$fee = 167.7;	break;
						case 25:	$fee = 174.7;	break;
						case 26:	$fee = 181.6;	break;
						case 27:	$fee = 188.6;	break;
						case 28:	$fee = 195.6;	break;
						case 29:	$fee = 202.6;	break;
						case 30:	$fee = 209.6;	break;
						case 31:	$fee = 216.6;	break;
						case 32:	$fee = 223.6;	break;
						case 33:	$fee = 230.5;	break;
						case 34:	$fee = 237.5;	break;
						case 35:	$fee = 244.5;	break;
						case 36:	$fee = 251.5;	break;
						case 37:	$fee = 258.5;	break;
						case 38:	$fee = 265.5;	break;
						case 39:	$fee = 272.4;	break;
						case 40:	$fee = 279.4;	break;
						case 41:	$fee = 286.4;	break;
						case 42:	$fee = 293.4;	break;
						case 43:	$fee = 300.4;	break;
						case 44:	$fee = 307.4;	break;
						case 45:	$fee = 314.4;	break;
						case 46:	$fee = 321.3;	break;
						case 47:	$fee = 328.3;	break;
						case 48:	$fee = 335.3;	break;
						case 49:	$fee = 342.3;	break;
						case 50:	$fee = 349.3;	break;
						case 51:	$fee = 356.3;	break;
						case 52:	$fee = 363.2;	break;
						case 53:	$fee = 370.2;	break;
						case 54:	$fee = 377.2;	break;
						case 55:	$fee = 384.2;	break;
						case 56:	$fee = 391.2;	break;
						case 57:	$fee = 398.2;	break;
						case 58:	$fee = 405.1;	break;
						case 59:	$fee = 412.1;	break;
						case 60:	$fee = 419.1;	break;
						case 61:	$fee = 426.1;	break;
						case 62:	$fee = 433.1;	break;
						case 63:	$fee = 440.1;	break;
						case 64:	$fee = 447.1;	break;
						case 65:	$fee = 454;	break;
						case 66:	$fee = 461;	break;
						case 67:	$fee = 468;	break;
						case 68:	$fee = 475;	break;
						case 69:	$fee = 482;	break;
						case 70:	$fee = 489;	break;
						case 71:	$fee = 495.9;	break;
						case 72:	$fee = 502.9;	break;
						case 73:	$fee = 509.9;	break;
						case 74:	$fee = 516.9;	break;
						case 75:	$fee = 523.9;	break;
						case 76:	$fee = 530.9;	break;
						case 77:	$fee = 537.9;	break;
						case 78:	$fee = 544.8;	break;
						case 79:	$fee = 551.8;	break;
						case 80:	$fee = 558.8;	break;
						case 81:	$fee = 565.8;	break;
						case 82:	$fee = 572.8;	break;
						case 83:	$fee = 579.8;	break;
						case 84:	$fee = 586.7;	break;
						case 85:	$fee = 593.7;	break;
						case 86:	$fee = 600.7;	break;
						case 87:	$fee = 607.7;	break;
						case 88:	$fee = 614.7;	break;
						case 89:	$fee = 621.7;	break;
						case 90:	$fee = 628.7;	break;
						case 91:	$fee = 635.6;	break;
						case 92:	$fee = 642.6;	break;
						case 93:	$fee = 649.6;	break;
						case 94:	$fee = 656.6;	break;
						case 95:	$fee = 663.6;	break;
						case 96:	$fee = 670.6;	break;
						case 97:	$fee = 677.5;	break;
						case 98:	$fee = 684.5;	break;
						case 99:	$fee = 691.5;	break;
						case 100:	$fee = 698.5;	break;
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
