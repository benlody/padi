<?php

namespace app\models;

use yii\db\ActiveRecord;

class Transaction2 extends ActiveRecord
{
	protected static $myTable;

	public function __construct($warehouse="tw", $type="padi") {

		parent::__construct();
		if(!self::$myTable){
			self::$myTable = $warehouse."_".$type."_transaction";
		}
	}


	/**
   	* @return string the associated database table name
   	*/
	public static function tableName() {
		return self::$myTable;
	}
}