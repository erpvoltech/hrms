<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qualification".
 *
 * @property int $id
 * @property string $qualification_name
 */
class Qualification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qualification_name'], 'required'],
            [['qualification_name'], 'string', 'max' => 250],
			[['qualification_name'], 'checkUniqQ'],		
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qualification_name' => 'Qualification Name',
        ];
    }
	
	public function checkUniqQ($attribute, $params)
	{
		$qualificationname = strtolower(str_replace(' ', '', $this->qualification_name));
		$qualification = Yii::$app->db->createCommand("SELECT id FROM qualification WHERE LOWER(replace(qualification_name ,' ',''))='" . $qualificationname . "'")->queryOne();
			if ($qualification)
			$this->addError($attribute, 'qualification name already added.');
	}
}
