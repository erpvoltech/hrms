<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "college".
 *
 * @property int $id
 * @property string $collegename
 */
class College extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'college';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collegename'], 'required'],
            [['collegename'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collegename' => 'Collegename',
        ];
    }
}
