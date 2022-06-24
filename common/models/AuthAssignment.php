<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "auth_assignment".
 *
 * @property int $id
 * @property int $empid
 * @property string $module
 * @property int $view_rights
 * @property int $create_rights
 * @property int $update_rights
 * @property int $delete_rights
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    public $rights;
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'module', 'view_rights', 'create_rights', 'update_rights', 'delete_rights','rights'], 'required'],
            [['userid', 'view_rights', 'create_rights', 'update_rights', 'delete_rights'], 'integer'],
            [['module'], 'string', 'max' => 250],
            [['module'], 'unique'],
			[['rights'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'User',
            'module' => 'Module',
			'rights' => 'Rights',
            'view_rights' => 'View',
            'create_rights' => 'Create',
            'update_rights' => 'Update',
            'delete_rights' => 'Delete',
        ];
    }	
	public function getUser() {
      return $this->hasOne(User::className(), ['id' => 'userid']);
	}
	
	public function Rights($module , $rights) {		
	$data = Yii::$app->db->createCommand('SELECT * FROM auth_assignment WHERE module="'.$module.'" AND userid='.Yii::$app->user->id)
           ->queryOne();
		   
	if($data){
		if($module == $data['module'] && $rights == 'view'){
			if($data['view_rights'] == 1)
			return true;	
		} else if($module == $data['module'] && $rights == 'create'){
			if($data['create_rights'] == 1)
			return true;	
		} else if($module == $data['module'] && $rights == 'update'){
			if($data['update_rights'] == 1)
			return true;	
		} else if($module == $data['module'] && $rights == 'delete'){
			if($data['delete_rights'] == 1)
			return true;	
		} else {
		return false;	
		}
	} 
	}
}