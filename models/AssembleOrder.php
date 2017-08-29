<?php

namespace app\models;

use Yii;


/*
CREATE TABLE `padi_test`.`assemble` ( `id` VARCHAR(32) NOT NULL , `content` TEXT NOT NULL , `extra_info` TEXT NULL , UNIQUE (`id`) ) ENGINE = InnoDB;
CREATE TABLE `padi_test`.`assemble_order` ( `id` VARCHAR(32) NOT NULL , `assemble` TEXT NOT NULL , `date` DATE NOT NULL , `done_date` DATE NOT NULL , `status` INT NOT NULL , `warehouse` TEXT NOT NULL , `qty` INT NOT NULL , `extra_info` TEXT NOT NULL , UNIQUE (`id`) , UNIQUE `assemble_order_id_index` (`id`(32)) ) ENGINE = InnoDB;
*/


class AssembleOrder extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_DONE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assemble_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assemble', 'date', 'status', 'warehouse'], 'required'],
            [['assemble', 'extra_info'], 'string'],
            [['date', 'done_date'], 'safe'],
            [['status', 'qty'], 'integer'],
            [['id', 'warehouse'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assemble' => Yii::t('app', 'Assemble Content'),
            'date' => Yii::t('app', 'Date'),
            'done_date' => Yii::t('app', 'Done Date'),
            'status' => Yii::t('app', 'Status'),
            'warehouse' => Yii::t('app', 'Warehouse'),
            'qty' => Yii::t('app', 'Qty'),
            'extra_info' => Yii::t('app', 'Extra Info'),
        ];
    }
}
