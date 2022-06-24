<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vgunit".
 *
 * @property int $id
 * @property string $unit_group
 */
class Vgunit extends \yii\db\ActiveRecord
{
    public $month;
    public static function tableName()
    {
        return 'vgunit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_group'], 'required'],
            [['unit_group'], 'string', 'max' => 250],
            [['month'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_group' => 'Unit Group',
            'month' => 'Month',
        ];
    }
}
