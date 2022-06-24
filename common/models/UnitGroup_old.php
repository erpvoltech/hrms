<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit_group".
 *
 * @property int $id
 * @property int $unit_group_id
 * @property int $unit_id
 */
class UnitGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vgunit_id', 'unit_id'], 'required'],
            [['vgunit_id', 'unit_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vgunit_id' => 'Unit Group',
            'unit_id' => 'Unit Name',
        ];
    }
}
