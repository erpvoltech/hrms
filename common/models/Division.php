<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "division".
 *
 * @property int $id
 * @property string $division_name
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division_name'], 'required'],
            [['division_name'], 'string', 'max' => 250],			
			[['division_name'], 'checkUniq'],			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division_name' => 'Division Name',		
        ];
    }
	
	public function checkUniq($attribute, $params)
	{
		$divisionname = strtolower(str_replace(' ', '', $this->division_name));
		$division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $divisionname . "'")->queryOne();
			if ($division)
			$this->addError($attribute, 'division_name already added.');
	}
}
