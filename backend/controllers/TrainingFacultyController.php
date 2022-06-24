<?php
namespace backend\controllers;
use Yii;
use app\models\TrainingFaculty;
use app\models\TrainingFacultySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EmpDetails;

use app\models\AuthAssignment;
use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * TrainingFacultyController implements the CRUD actions for TrainingFaculty model.
*/
class TrainingFacultyController extends Controller
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
					// deny all POST requests
					/*[
						'allow' => false,							
						'verbs' => ['POST']
					],*/
					
					// allow authenticated users
					[
						'allow' => true,
						'actions' => ['index','view','ajax-ecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'view');									 
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','update','ajax-ecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'update');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','create','ajax-ecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										return AuthAssignment::Rights('post recruitment', 'create');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','delete','ajax-ecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'delete');									 
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
     * Lists all TrainingFaculty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingFacultySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrainingFaculty model.
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
     * Creates a new TrainingFaculty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrainingFaculty();

        if ($model->load(Yii::$app->request->post()) ) {
			$now_date					=	date("Y-m-d");
			$model->created_by		=	Yii::$app->user->identity->username;
			$model->created_date	=	$now_date;
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrainingFaculty model.
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
     * Deletes an existing TrainingFaculty model.
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
     * Finds the TrainingFaculty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrainingFaculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrainingFaculty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionAjaxEcode()
    {		
	
        if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();			
			$faculty_ecode = explode(":", $data['faculty_ecode']);
			$ename = EmpDetails::find()->where(['empcode' => $faculty_ecode])->one();
			echo $ename['empname'];					
		}
    }
}
