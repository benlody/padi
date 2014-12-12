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
 * @property string $contact
 * @property string $tel
 * @property string $content
 * @property integer $ship_type
 * @property string $date
 * @property string $issue_by
 * @property integer $check
 * @property integer $box_num
 * @property integer $weight
 * @property string $shipping_no
 * @property integer $status
 * @property string $extra_info
 */
class Order extends \yii\db\ActiveRecord
{
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
            [['id', 'customer_id', 'chinese_addr', 'english_addr', 'contact', 'tel', 'content', 'date', 'issue_by', 'shipping_no'], 'required'],
            [['ship_type', 'check', 'box_num', 'weight', 'status'], 'integer'],
            [['date'], 'safe'],
            [['id', 'customer_id', 'chinese_addr', 'english_addr', 'contact', 'tel', 'content', 'issue_by', 'shipping_no', 'extra_info'], 'string', 'max' => 255]
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
            'contact' => Yii::t('app', 'Contact'),
            'tel' => Yii::t('app', 'Tel'),
            'content' => Yii::t('app', 'Content'),
            'ship_type' => Yii::t('app', 'Ship Type'),
            'date' => Yii::t('app', 'Date'),
            'issue_by' => Yii::t('app', 'Issue By'),
            'check' => Yii::t('app', 'Check'),
            'box_num' => Yii::t('app', 'Box Num'),
            'weight' => Yii::t('app', 'Weight'),
            'shipping_no' => Yii::t('app', 'Shipping No'),
            'status' => Yii::t('app', 'Status'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}