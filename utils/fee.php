
<?php

require_once __DIR__  . '/enum.php';

class Fee
{

	static public function getCrewpackServiceFee($qty, $warehouse){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 7 * $qty;
		} else {
			$fee = round((30 * $qty) * 100 / 24) / 100;
		}
		return $fee;
	}

	static public function getProductServiceFee($qty, $warehouse){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 2 * $qty;
		} else {
			$fee = round((5 * $qty) * 100 / 24) / 100;
		}
		return $fee;
	}

	static public function getShipFreightFee($org_fee, $region, $warehouse, $type, $weight, $box){

		if(ShippingType::T_SELFPICK == $type){
			return 0;
		}

		if(0 == strcmp('xm', $warehouse)){
			switch ($region) {
				case 'Hebei':
				case 'Yunnan':
				case 'Shandong':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 100) ? (12 + 10 * $weight) : (($weight <= 300) ? (112 + 9 * $weight) : ((412 + 8 * $weight)))));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : ((250 + 4.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;
				
				case 'Shanghai':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 100) ? (12 + 10 * $weight) : (($weight <= 300) ? (112 + 9 * $weight) : ((412 + 8 * $weight)))));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : ((200 + 3.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Guangdong':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (16 + 6 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : ((200 + 3.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Hainan':
				case 'Guangxi':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 100) ? (14 + 8 * $weight) : ((144 + 7 * $weight))));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (14 + 4 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 38) ? (150) : (($weight <= 50) ? (4 * $weight) : ((200 + 3.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;
				
				case 'Liaoning':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 50) ? (9 + 13 * $weight) : (($weight <= 300) ? (109 + 11 * $weight) : ((409 + 10 * $weight)))));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (11 + 7 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : ((250 + 4.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Sichuan':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 100) ? (12 + 10 * $weight) : (($weight <= 300) ? (112 + 9 * $weight) : ((412 + 8 * $weight)))));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 34) ? (150) : (($weight <= 50) ? (4.5 * $weight) : ((225 + 4 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Shaanxi':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (($weight < 100) ? (12 + 10 * $weight) : (($weight <= 300) ? (112 + 9 * $weight) : ((412 + 8 * $weight)))));
					} else if (ShippingType::T_SF_SP== $type) {
						$fee = ceil(1.1 * (13 + 5 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 30) ? (150) : (($weight <= 50) ? (5 * $weight) : ((250 + 4.5 * ($weight - 50))))));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Fuzhou':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (11 + 2 * $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				case 'Xiamen':
					if(ShippingType::T_STD_EXPR== $type){
						$fee = ceil(1.1 * (11 + $weight));
					} else if (ShippingType::T_SF_NORMAL== $type) {
						$fee = ceil(1.1 * (($weight < 120) ? (120) : ($weight)));
					} else {
						$fee = 1.1 * $org_fee;
					}
					break;

				default:
					$fee = 1.1 * $org_fee;
					break;
			}

		} else {
			if(ShippingType::T_NEW == $type){
				$fee = 11 * $box;
			} else {
				$fee = 1.1 * $org_fee / 24;
			}
		}

		return ceil($fee);
	}

}
