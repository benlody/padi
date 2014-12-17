<?php

namespace app\models;

use yii\db\ActiveRecord;

class Balance1 extends ActiveRecord
{
	protected static $myTable;

	public function __construct($warehouse="tw", $type="padi") {

		parent::__construct();
		if(!self::$myTable){
			self::$myTable = $warehouse."_".$type."_balance";
		}
	}


	/**
   	* @return string the associated database table name
   	*/
	public static function tableName() {
		return self::$myTable;
	}

}

