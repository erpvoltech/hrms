<?php

namespace app\models;

use Yii;
use common\models\EmpDetails;
/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
	public function getEmployee()
    {
        return $this->hasMany(EmpDetails::className(), ['department_id' => 'id']);
    }
}
