
<?php

class Fee
{

	static public function getCrewpackServiceFee($qty, $warehouse){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 30 * $qty;
		} else {
			$fee = 30 * $qty;
		}
		return $fee;
	}

	static public function getProductServiceFee($qty, $warehouse){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 5 * $qty;
		} else {
			$fee = 5 * $qty;
		}
		return $fee;
	}

	static public function getShipFee($org_fee, $region, $warehouse){

		if(0 == strcmp('xm', $warehouse)){
			$fee = 1.1 * $org_fee;
		} else {
			$fee = 1.1 * $org_fee;
		}
		return $fee;
	}

}
