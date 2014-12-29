<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $customer_id
 * @property string $chinese_addr
 * @property string $english_addr
 * @property string $region
 * @property string $contact
 * @property string $tel
 * @property string $content
 * @property integer $ship_type
 * @property string $date
 * @property string $done_date
 * @property string $warehouse
 * @property string $shipping_info
 * @property integer $status
 * @property string $extra_info
 */
class Order extends \yii\db\ActiveRecord
{

	const STATUS_NEW = 0;
	const STATUS_DONE = 1;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'order';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'customer_id', 'content', 'ship_type', 'date', 'warehouse', 'status'], 'required'],
			[['chinese_addr', 'english_addr', 'contact', 'tel', 'content', 'shipping_info', 'extra_info'], 'string'],
			[['ship_type', 'status'], 'integer'],
			[['date', 'done_date'], 'safe'],
			[['id', 'customer_id', 'region', 'warehouse'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'customer_id' => Yii::t('app', 'Customer ID'),
			'chinese_addr' => Yii::t('app', 'Chinese Addr'),
			'english_addr' => Yii::t('app', 'English Addr'),
			'region' => Yii::t('app', 'Region'),
			'contact' => Yii::t('app', 'Contact'),
			'tel' => Yii::t('app', 'Tel'),
			'content' => Yii::t('app', 'Content'),
			'ship_type' => Yii::t('app', 'Ship Type'),
			'date' => Yii::t('app', 'Date'),
			'done_date' => Yii::t('app', 'Done Date'),
			'warehouse' => Yii::t('app', 'Warehouse'),
			'shipping_info' => Yii::t('app', 'Shipping Info'),
			'status' => Yii::t('app', 'Status'),
			'extra_info' => Yii::t('app', 'Extra Info'),
		];
	}
}
