<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marketing".
 *
 * @property integer $id
 * @property string $date
 * @property string $content
 * @property string $tracking
 * @property string $weight
 * @property integer $orig_fee
 * @property integer $req_fee
 * @property string $extra_info
 */
class Marketing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marketing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'orig_fee', 'req_fee'], 'required'],
            [['date'], 'safe'],
            [['content', 'tracking', 'weight', 'extra_info'], 'string'],
            [['orig_fee', 'req_fee'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'content' => Yii::t('app', 'Content'),
            'tracking' => Yii::t('app', 'Tracking'),
            'weight' => Yii::t('app', 'Weight'),
            'orig_fee' => Yii::t('app', 'Orig Fee'),
            'req_fee' => Yii::t('app', 'Req Fee'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
