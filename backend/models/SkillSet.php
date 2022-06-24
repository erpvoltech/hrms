<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skill_set".
 *
 * @property int $id
 * @property string $zone
 * @property double $highly_skilled
 * @property double $skilled
 * @property double $semi_skilled
 * @property double $un_skilled
 */
class SkillSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone', 'highly_skilled', 'skilled', 'semi_skilled', 'un_skilled'], 'required'],
            [['highly_skilled', 'skilled', 'semi_skilled', 'un_skilled'], 'number'],
            [['zone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zone' => 'Zone',
            'highly_skilled' => 'Highly Skilled',
            'skilled' => 'Skilled',
            'semi_skilled' => 'Semi Skilled',
            'un_skilled' => 'Un Skilled',
        ];
    }
}
