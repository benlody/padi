<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property string $id
 * @property string $chinese_name
 * @property string $english_name
 * @property string $level
 * @property string $contact
 * @property string $tel
 * @property string $email
 * @property string $chinese_addr
 * @property string $english_addr
 * @property string $region
 * @property string $extra_info
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['chinese_name', 'english_name', 'contact', 'tel', 'email', 'chinese_addr', 'english_addr', 'extra_info'], 'string'],
            [['id', 'level', 'region'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Member No.'),
            'chinese_name' => Yii::t('app', 'Chinese Name'),
            'english_name' => Yii::t('app', 'English Name'),
            'level' => Yii::t('app', 'Level'),
            'contact' => Yii::t('app', 'Contact'),
            'tel' => Yii::t('app', 'Tel'),
            'email' => Yii::t('app', 'Email'),
            'chinese_addr' => Yii::t('app', 'Chinese Address'),
            'english_addr' => Yii::t('app', 'English Address'),
            'region' => Yii::t('app', 'Region'),
            'extra_info' => Yii::t('app', 'Remark'),
        ];
    }
}
