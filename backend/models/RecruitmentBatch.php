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
class RecruitmentBatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recruitment_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'batch_name'], 'required'],
            [['date'], 'safe'],
            [['batch_name'], 'string', 'max' => 250],
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
            'batch_name' => 'Batch Name',
        ];
    }
	
	public function getRecruitment()
    {
        return $this->hasOne(Recruitment::className(), ['batch_id' => 'id']);
    }
}
