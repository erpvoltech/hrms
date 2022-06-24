<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recruitment_batch".
 *
 * @property int $id
 * @property string $date
 * @property string $batch_name
 */
class TrainingBatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'training_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'training_batch_name'], 'required'],
            [['date'], 'safe'],
            [['training_batch_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'training_batch_name' => 'Training Batch Name',
        ];
    }
}
