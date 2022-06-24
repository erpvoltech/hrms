<?php
    namespace app\models;
    use common\models\User;
    use yii\base\Model;

    class ChangePassword extends Model
    {
      public $password;
      public $changepassword;
      public $reenterpassword;

      public function rules()
       {
        return [

        ['password', 'validatePassword'],
        ['changepassword', 'required'],
        ['reenterpassword', 'required'],
        ['reenterpassword', 'compare', 'compareAttribute'=>'changepassword', 'message'=>"Passwords don't match" ]
        ];
      }

	public function attributeLabels()
	{
    return [
        
        'password' => 'Password',
        'changepassword' => 'Change Password',
        'reenterpassword' => 'Re-enter Password',
        ];
    }

     public function validatePassword($attribute, $params)
     {
      if (!$this->hasErrors()) {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect username or password.');
         }
        }
       }

    protected function getUser()
    {
		if ($this->_user === null) {
		  $this->_user = User::findByUsername($this->username);
		}

		return $this->_user;
	}

    }