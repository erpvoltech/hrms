<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit_group".
 *
 * @property int $id
 * @property int $unit_id
 * @property int $division_id
 * @property int $priority
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
            [['unit_id', 'division_id'], 'required'],
            [['unit_id', 'division_id', 'priority'], 'integer'],			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit',
            'division_id' => 'Division',
            'priority' => 'Priority',
        ];
    }
}
