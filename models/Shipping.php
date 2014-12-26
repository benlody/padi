<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipping".
 *
 * @property string $id
 * @property string $order_id
 * @property string $content
 * @property string $send_date
 * @property integer $ship_type
 * @property string $warehouse
 * @property integer $packing_fee
 * @property integer $shipping_fee
 * @property double $request_fee
 * @property string $extra_info
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'content', 'send_date', 'ship_type', 'warehouse', 'packing_fee', 'shipping_fee', 'request_fee'], 'required'],
            [['content', 'extra_info'], 'string'],
            [['send_date'], 'safe'],
            [['ship_type', 'packing_fee', 'shipping_fee'], 'integer'],
            [['request_fee'], 'number'],
            [['id', 'order_id', 'warehouse'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'content' => Yii::t('app', 'Content'),
            'send_date' => Yii::t('app', 'Send Date'),
            'ship_type' => Yii::t('app', 'Ship Type'),
            'warehouse' => Yii::t('app', 'Warehouse'),
            'packing_fee' => Yii::t('app', 'Packing Fee'),
            'shipping_fee' => Yii::t('app', 'Shipping Fee'),
            'request_fee' => Yii::t('app', 'Request Fee'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
