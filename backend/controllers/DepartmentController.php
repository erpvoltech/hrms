<?php

namespace backend\controllers;

use Yii;
use common\models\Department;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EmpDetails;

use app\models\AuthAssignment;
use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
{
    /**
     * @inheritdoc
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
						// deny all POST requests
						/*[
							'allow' => false,							
							'verbs' => ['POST']
						],*/
						
						// allow authenticated users
						[
							'allow' => true,
							'actions' => ['index','view'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','update'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('mis', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','delete'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'delete');									 
								 },
							'roles' => ['@'],
						],
						// everything else is denied
					],
				],
			];
       }
	
	
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Department::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Department model.
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
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Department model.
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
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$ModelEmp = EmpDetails::find()->where(['department_id' =>$id])->one();
	
		if(!$ModelEmp)
			$this->findModel($id)->delete();
		else 
			Yii::$app->session->addFlash("error", 'Employees Assigned to this Department Change Employee Department before delete');
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
