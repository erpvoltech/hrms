<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "training_topics".
 *
 * @property int $id
 * @property string $topic_name
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 */
class TrainingTopics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_topics_frontend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_name', 'created_by', 'created_date'], 'required'],
            //[['topic_name', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
            [['created_date'], 'safe'],
            [['topic_name'], 'string', 'max' => 255],
            [['created_by','updated_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_name' => 'Topic Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }
}
