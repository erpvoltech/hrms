<?php
namespace frontend\controllers;
use Yii;
use app\models\TrainingTopics;
use app\models\TrainingTopicsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//use app\models\AuthAssignment;
use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * TrainingTopicsController implements the CRUD actions for TrainingTopics model.
 */
class TrainingTopicsController extends Controller
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
     * Lists all TrainingTopics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingTopicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrainingTopics model.
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
     * Creates a new TrainingTopics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrainingTopics();

        if ($model->load(Yii::$app->request->post())) {
			
			$now_date		=	date("Y-m-d");
			$model->created_by		=	Yii::$app->user->identity->username;
			$model->created_date	=	$now_date;
			#$model->created_date	=	Yii::$app->formatter->asDate($now_date);
			$model->updated_by		=	'';
			$model->updated_date	=	'';
			
			if($model->save()){
				return $this->redirect(['index', 'id' => $model->id]);
			}else{
				// show errors
				var_dump($model->getErrors());
				exit;
			}
            #return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrainingTopics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model 				= $this->findModel($id);		
		
        if ($model->load(Yii::$app->request->post())) {
			$now_date		=	date("Y-m-d");
			$model->updated_by		=	Yii::$app->user->identity->username;
			$model->updated_date	=	$now_date;			
			
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	
	/*public function actionImport(){		
        $modelImport = new \yii\base\DynamicModel([
                    'fileupload'=>'File Import',
                ]);
        $modelImport->addRule(['fileImport'],'required');
        $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx'],['maxSize'=>1024*1024]);
		$model = new TrainingTopics();
        if(Yii::$app->request->post()){
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport,'fileImport');
            if($modelImport->fileImport && $modelImport->validate()){
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $baseRow = 3;
				
                while(!empty($sheetData[$baseRow]['B'])){
                    $model = new TrainingTopics();
                    $model->topic_name = (string)$sheetData[$baseRow]['B'];
                    $model->created_by = (string)$sheetData[$baseRow]['C'];
                    $model->created_date = (string)$sheetData[$baseRow]['C'];
                    $model->save();
                    $baseRow++;
                }
                Yii::$app->getSession()->setFlash('success','Success');
            }else{
                Yii::$app->getSession()->setFlash('error','Error');
            }
        }

        return $this->render('import',[
                'model' => $model,
            ]);
    }*/


    /**
     * Deletes an existing TrainingTopics model.
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
     * Finds the TrainingTopics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrainingTopics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrainingTopics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
