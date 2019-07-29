<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notify".
 *
 * @property integer $id
 * @property string $name
 * @property string $pw
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'pw'], 'required'],
            [['id'], 'integer'],
            [['name', 'pw'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'pw' => Yii::t('app', 'Pw'),
        ];
    }
}
