<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "packing".
 *
 * @property string $id
 * @property integer $qty
 * @property string $net_weight
 * @property string $measurement
 */
class Packing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'packing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['qty'], 'integer'],
            [['net_weight', 'measurement'], 'string'],
            [['id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'qty' => Yii::t('app', 'Qty'),
            'net_weight' => Yii::t('app', 'Net Weight'),
            'measurement' => Yii::t('app', 'Measurement'),
        ];
    }
}
