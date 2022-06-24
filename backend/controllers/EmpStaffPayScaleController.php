<?php

namespace backend\controllers;

use Yii;
use app\models\EmpStaffPayScale;
use app\models\EmpStaffPayScaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EmpDetails;

use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\AuthAssignment;

/**
 * EmpStaffPayScaleController implements the CRUD actions for EmpStaffPayScale model.
 */
class EmpStaffPayScaleController extends Controller {

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
							'actions' => ['index','view'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['update'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('payroll', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['delete'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'delete');									 
								 },
							'roles' => ['@'],
						],
						// everything else is denied
					],
				],
			];
       }
	
	
   /*public function behaviors() {
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
    * Lists all EmpStaffPayScale models.
    * @return mixed
    */
   public function actionIndex() {
      $searchModel = new EmpStaffPayScaleSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Displays a single EmpStaffPayScale model.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionView($id) {
      return $this->render('view', [
                  'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new EmpStaffPayScale model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate() {
      $model = new EmpStaffPayScale();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
                  'model' => $model,
      ]);
   }

   /**
    * Updates an existing EmpStaffPayScale model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
                  'model' => $model,
      ]);
   }

   /**
    * Deletes an existing EmpStaffPayScale model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionDelete($id) {
      $ModelEmp = EmpDetails::find()->where(['staff_pay_scale_id' => $id])->one();

      if (!$ModelEmp)
         $this->findModel($id)->delete();
      else
         Yii::$app->session->addFlash("error", 'Employees Assigned to this PayScale Change Employee PayScale before delete');

      return $this->redirect(['index']);
   }

   /**
    * Finds the EmpStaffPayScale model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return EmpStaffPayScale the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id) {
      if (($model = EmpStaffPayScale::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }

}
