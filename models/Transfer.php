<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property string $id
 * @property string $content
 * @property string $send_date
 * @property string $recv_date
 * @property integer $status
 * @property string $src_warehouse
 * @property string $dst_warehouse
 * @property string $extra_info
 */
class Transfer extends \yii\db\ActiveRecord
{

	const STATUS_NEW = 0;
	const STATUS_DONE = 1;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'transfer';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'content', 'status', 'src_warehouse', 'dst_warehouse'], 'required'],
			[['content', 'extra_info'], 'string'],
			[['send_date', 'recv_date'], 'safe'],
			[['status'], 'integer'],
			[['id', 'src_warehouse', 'dst_warehouse'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'content' => Yii::t('app', 'Content'),
			'send_date' => Yii::t('app', 'Send Date'),
			'recv_date' => Yii::t('app', 'Recv Date'),
			'status' => Yii::t('app', 'Status'),
			'src_warehouse' => Yii::t('app', 'Src Warehouse'),
			'dst_warehouse' => Yii::t('app', 'Dst Warehouse'),
			'extra_info' => Yii::t('app', 'Extra Info'),
		];
	}
}
