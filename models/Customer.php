<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $chinese_name
 * @property string $english_name
 * @property string $level
 * @property string $contact
 * @property string $tel
 * @property string $email
 * @property string $chinese_addr
 * @property string $english_addr
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
            [['id', 'chinese_name', 'english_name', 'level', 'contact', 'tel', 'email', 'chinese_addr', 'english_addr'], 'required'],
            [['id'], 'integer'],
            [['chinese_name', 'english_name', 'level', 'contact', 'tel', 'email', 'chinese_addr', 'english_addr', 'extra_info'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chinese_name' => Yii::t('app', 'Chinese Name'),
            'english_name' => Yii::t('app', 'English Name'),
            'level' => Yii::t('app', 'Level'),
            'contact' => Yii::t('app', 'Contact'),
            'tel' => Yii::t('app', 'Tel'),
            'email' => Yii::t('app', 'Email'),
            'chinese_addr' => Yii::t('app', 'Chinese Addr'),
            'english_addr' => Yii::t('app', 'English Addr'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}