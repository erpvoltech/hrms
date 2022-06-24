<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\ResetPasswordForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DivisionController implements the CRUD actions for Division model.
 */
class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Division models.
     * @return mixed
    */
	
	public function actionIndex(){
		echo "hi";
		exit;
	}
	
	
    /*public function actionSavechangepassword()
	{		
		#$model 	= 	new User;
		$id		=	Yii::$app->user->identity->id;

		$model = $this->findModel($id);
		#$model = User::model()->findByAttributes(array('id'=>$id));
		$model->setScenario('changePwd');

		 if(isset($_POST['User'])){
				
			$model->attributes = $_POST['User'];
			$valid = $model->validate();
					
			if($valid){
					
			  $model->password_hash = md5($model->new_password);
					
			  if($model->save())
				 $this->redirect(array('changepassword','msg'=>'successfully changed password'));
			  else
				 $this->redirect(array('changepassword','msg'=>'password not changed'));
				}
			}

		$this->render('update',array('model'=>$model));	
	}*/

    public function actionResetprofilepassword()
    {
		$model = new ResetPasswordForm();
		#echo "<pre>";print_r($resetpasswordmodel);echo "</pre>";
		#exit;
		if ($model->load(Yii::$app->request->post())) {
			
			#echo "<pre>";print_r(Yii::$app->request->post());echo "</pre>";			
			$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
			
			$user->setPassword($model->changepassword);
			$user->generateAuthKey();
			
			#$user->password_hash = md5($model->changepassword);
			#echo "</br>password_hash: ".$user->password_hash;
			#exit;
			#echo $user->password_hash;
			#exit;
			
			if($user->validate()){
				$user->save(false);
				Yii::$app->session->setFlash('success', 'New password saved.');

				return $this->goHome();
			}
		 }
		return $this->render('resetPassword', [
		'model' => $model
		]);
    }
}
