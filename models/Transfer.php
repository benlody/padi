<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property string $id
 * @property string $chinese_addr
 * @property string $english_addr
 * @property string $contact
 * @property string $tel
 * @property string $content
 * @property string $send_date
 * @property string $recv_date
 * @property integer $status
 * @property string $src_warehouse
 * @property string $dst_warehouse
 * @property string $ship_type
 * @property string $shipping_info
 * @property string $extra_info
 */
class Transfer extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_DONE = 1;
    const STATUS_ONTHEWAY = 2;

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
            [['chinese_addr', 'english_addr', 'contact', 'tel', 'content', 'shipping_info', 'extra_info'], 'string'],
            [['send_date', 'recv_date'], 'safe'],
            [['status'], 'integer'],
            [['id', 'src_warehouse', 'dst_warehouse', 'ship_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chinese_addr' => Yii::t('app', 'Chinese Addr'),
            'english_addr' => Yii::t('app', 'English Addr'),
            'contact' => Yii::t('app', 'Contact'),
            'tel' => Yii::t('app', 'Tel'),
            'content' => Yii::t('app', 'Content'),
            'send_date' => Yii::t('app', 'Send Date'),
            'recv_date' => Yii::t('app', 'Recv Date'),
            'status' => Yii::t('app', 'Status'),
            'src_warehouse' => Yii::t('app', 'Src Warehouse'),
            'dst_warehouse' => Yii::t('app', 'Dst Warehouse'),
            'ship_type' => Yii::t('app', 'Ship Type'),
            'shipping_info' => Yii::t('app', 'Shipping Info'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
