<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $empid
 * @property int $date
 * @property string $document
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','date', 'document','type'], 'required'],
            [['empid','type','mail'], 'integer'],
            [['document','file_name'],'string'],
			[['date','last_working_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'ECode',
            'date' => 'Date',
			'type' => 'Document Type',
            'document' => 'Document',
			'last_working_date'=> 'Last Working Date',
        ];
    }
	 public function getEmployee()
    {
        return $this->hasOne(EmpDetails::className(), ['id'=>'empid']);
    }
}
