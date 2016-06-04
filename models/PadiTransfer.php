<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "padi_transfer".
 *
 * @property string $id
 * @property string $content
 * @property string $date
 * @property string $src_warehouse
 * @property string $dst_warehouse
 * @property string $extra_info
 */
class PadiTransfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'padi_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content', 'src_warehouse', 'dst_warehouse'], 'required'],
            [['content', 'extra_info'], 'string'],
            [['date'], 'safe'],
            [['id'], 'string', 'max' => 64],
            [['src_warehouse', 'dst_warehouse'], 'string', 'max' => 255]
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
            'src_warehouse' => Yii::t('app', 'Src Warehouse'),
            'dst_warehouse' => Yii::t('app', 'Dst Warehouse'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
