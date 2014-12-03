<?php

namespace app\models;

use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
	private $myTable;

	public function __construct($warehouse="tw", $type="padi") {

		$this->myTable = $warehouse."_".$type."_transaction";
		parent::__construct();
	}


	/**
   	* @return string the associated database table name
   	*/
	public function tableName() {
		return $this->myTable;
	}
}