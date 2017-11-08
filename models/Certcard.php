<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "certcard".
 *
 * @property integer $id
 * @property string $t_send_date
 * @property string $DHL
 * @property string $tracking
 * @property integer $small_box
 * @property string $s_recv_date
 * @property integer $orig_fee
 * @property integer $req_fee
 * @property string $extra_info
 */
class Certcard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certcard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_send_date'], 'required'],
            [['t_send_date', 's_recv_date'], 'safe'],
            [['DHL', 'tracking', 'extra_info'], 'string'],
            [['small_box', 'orig_fee', 'req_fee'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            't_send_date' => Yii::t('app', 'T Send Date'),
            'DHL' => Yii::t('app', 'Dhl'),
            'tracking' => Yii::t('app', 'Tracking'),
            'small_box' => Yii::t('app', 'Small Box'),
            's_recv_date' => Yii::t('app', 'S Recv Date'),
            'orig_fee' => Yii::t('app', 'Orig Fee'),
            'req_fee' => Yii::t('app', 'Req Fee'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
