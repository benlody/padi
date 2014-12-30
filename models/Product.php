<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $chinese_name
 * @property string $english_name
 * @property integer $warning_cnt_tw
 * @property integer $warning_cnt_xm
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
            [['chinese_name', 'english_name', 'extra_info'], 'string'],
            [['warning_cnt_tw', 'warning_cnt_xm'], 'integer'],
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
            'chinese_name' => Yii::t('app', 'Chinese Name'),
            'english_name' => Yii::t('app', 'English Name'),
            'warning_cnt_tw' => Yii::t('app', 'Warning Cnt Tw'),
            'warning_cnt_xm' => Yii::t('app', 'Warning Cnt Xm'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
