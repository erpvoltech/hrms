<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DivisionController implements the CRUD actions for Division model.
 */
class UserController extends Controller
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
	
	public function actionChangepassword($id)
	{		
		$model 	= 	new User;		

		$model = $this->findModel($id);
		
		return $this->render('create', [
            'model' => $model,
        ]);		
	}
	
    public function actionSavechangepassword()
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
	}

    /**
     * Displays a single Division model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Updates an existing Division model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

   
    /**
     * Finds the Division model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Division the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
