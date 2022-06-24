<?php

namespace backend\controllers;

use Yii;
//use common\models\AuthAssignment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AttendanceAccessRule;
use app\models\AuthAssignment;

use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * AuthAssignmentController implements the CRUD actions for AuthAssignment model.
 */
class AuthAssignmentController extends Controller
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
				   'delete' => ['post'],
			   ],
		   ],
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				//'only' => ['create','update','view','delete'],
				'rules' => [
					// allow authenticated users
					[
						'allow' => true,
						'actions' => ['index','view'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('authentication', 'view','attendance-access');									 
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['update'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('authentication', 'update');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['create','attendance-access'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										return AuthAssignment::Rights('authentication', 'create','attendance-access');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['delete'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('authentication', 'delete');									 
							 },
						'roles' => ['@'],
					],
					// everything else is denied
				],
			],
		];
    } 
	 /*
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
*/
    /**
     * Lists all AuthAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthAssignment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	


    /**
     * Displays a single AuthAssignment model.
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
     * Creates a new AuthAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthAssignment();

        if ($model->load(Yii::$app->request->post())  ) {	
		foreach($model->rights as $rights){
			if($rights == 'v')
				$model->view_rights = 1;
			if($rights == 'c')
				$model->create_rights = 1;
			if($rights == 'u')
				$model->update_rights = 1;
			if($rights == 'd')
				$model->delete_rights = 1;
			}
		$model->save(false);
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
		
		$model->save(false);
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionAttendanceAccess()
{
    $model = new AttendanceAccessRule();
	//$modelUser = User::find()->where(['id'=>'username'])->all();
	//print_r($modelUser);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return $this->redirect('attendance-access');
        }
    }

    return $this->render('attendance-access', [
        'model' => $model,
		//'modeluser'=> $modelUser,
    ]);
}


    /**
     * Deletes an existing AuthAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthAssignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
