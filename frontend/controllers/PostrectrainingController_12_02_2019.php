<?php

namespace frontend\controllers;

use Yii;
use app\models\PorecTraining;
use app\models\PorecTrainingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostrectrainingController implements the CRUD actions for PorecTraining model.
 */
class PostrectrainingController extends Controller
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
     * Lists all PorecTraining models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PorecTrainingSearch();				
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);				
    }

    /**
     * Displays a single PorecTraining model.
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
     * Creates a new PorecTraining model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PorecTraining();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PorecTraining model.
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
     * Deletes an existing PorecTraining model.
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
     * Finds the PorecTraining model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PorecTraining the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PorecTraining::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionPrint1()
    {
        #$searchModel = new PorecTrainingSearch();				
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$model = new PorecTraining();
		
		/*return $this->render('print1', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);*/
		
		if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['print1', 'id' => $model->id]);
        }
		
        return $this->render('print1', [
            'model' => $model,
        ]);
    }
	
	public function actionPrint2()
    {
        #$searchModel = new PorecTrainingSearch();				
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$model = new PorecTraining();
		
		/*return $this->render('print1', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);*/
		
		if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['print2', 'id' => $model->id]);
        }
		
		
        return $this->render('print2', [
            'model' => $model,
        ]);
    }
	
	public function actionPrint3()
    {
        #$searchModel = new PorecTrainingSearch();				
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$model = new PorecTraining();
		
		/*return $this->render('print1', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);*/
		
		if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['print3', 'id' => $model->id]);
        }
		
		
        return $this->render('print3', [
            'model' => $model,
        ]);
    }
	
	
}