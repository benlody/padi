<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $chinese_name
 * @property string $english_name
 * @property integer $favor
 * @property string $extra_info
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['favor'], 'integer'],
            [['id'], 'string', 'max' => 64],
            [['chinese_name', 'english_name', 'extra_info'], 'string', 'max' => 255]
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
            'favor' => Yii::t('app', 'Favor'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
