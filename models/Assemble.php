<?php

namespace app\models;

use Yii;


/*
CREATE TABLE `padi_test`.`assemble` ( `id` VARCHAR(32) NOT NULL , `content` TEXT NOT NULL , `extra_info` TEXT NULL , UNIQUE (`id`) ) ENGINE = InnoDB;
CREATE TABLE `padi_test`.`assemble_order` ( `id` VARCHAR(32) NOT NULL , `assemble` TEXT NOT NULL , `date` DATE NOT NULL , `done_date` DATE NOT NULL , `status` INT NOT NULL , `warehouse` TEXT NOT NULL , `qty` INT NOT NULL , `extra_info` TEXT NOT NULL , UNIQUE (`id`) , UNIQUE `assemble_order_id_index` (`id`(32)) ) ENGINE = InnoDB;
*/

/**
 * This is the model class for table "assemble".
 *
 * @property string $id
 * @property string $content
 */
class Assemble extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assemble';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['content'], 'string'],
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
        ];
    }
}
