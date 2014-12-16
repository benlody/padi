<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property string $id
 * @property string $content
 * @property string $date
 * @property string $done_date
 * @property integer $status
 * @property string $warehouse
 * @property string $extra_info
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content', 'date', 'status', 'warehouse'], 'required'],
            [['date', 'done_date'], 'safe'],
            [['status'], 'integer'],
            [['id', 'content', 'warehouse', 'extra_info'], 'string', 'max' => 255]
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
            'date' => Yii::t('app', 'Date'),
            'done_date' => Yii::t('app', 'Done Date'),
            'status' => Yii::t('app', 'Status'),
            'warehouse' => Yii::t('app', 'Warehouse'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
