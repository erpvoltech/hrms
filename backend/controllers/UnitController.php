<?php

namespace backend\controllers;

use Yii;
use common\models\Unit;
use common\models\UnitGroup;
use common\models\Vgunit;
use common\models\Division;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\AuthAssignment;
use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends Controller {

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
							'actions' => ['index','view','group-index','create-group','set-priority'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','update','group-update','group-index','create-group','set-priority'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create','create-division','group-index','set-priority'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('mis', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','delete','group-index','set-priority'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'delete');									 
								 },
							'roles' => ['@'],
						],
						[
							'allow' => true,
							'roles' => ['@'],
						],
					],
				],
			];
       }
	
  public function actionSetPriority($id) {
      $model = new UnitGroup();
	 if ($model->load(Yii::$app->request->post()) ) {
	 $Unitgroup = UnitGroup::find()->where(['unit_id'=>$id])->orderBy(['id'=>SORT_ASC])->all();
	 $i=0;
	 foreach($Unitgroup as $group){	 	
	 $groupmodel = UnitGroup::find()->where(['id'=>$group->id])->one();
	 $groupmodel->priority =$model->priority[$i];
	 $groupmodel->save(false);
	 $i++;
	 }	
      return $this->redirect(['group-index']);
      } 
      return $this->render('set-priority', [
                  'model' => $model,
				  'id'=>$id,
      ]);
   }
   public function actionPriorityCancel() {
   return $this->redirect(['group-index']);
   }
  
	
   public function actionIndex() {
      $dataProvider = new ActiveDataProvider([
          'query' => Unit::find(),
      ]);

      return $this->render('index', [
                  'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Displays a single Unit model.
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
    * Creates a new Unit model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate() {
      $model = new Unit();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
                  'model' => $model,
      ]);
   }
   
   public function actionGroupIndex() {
	    return $this->render('group-index');
   }
   
   public function actionCreateGroup() {
      $model = new Vgunit();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['group-index']);
      }

      return $this->render('create-group', [
                  'model' => $model,
      ]);
   }
   
     public function actionCreateDivision() {
      $model = new Division();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['index']);
      }

      return $this->render('division_form', [
                  'model' => $model,
      ]);
   }
   
    public function actionGroupUnit() {
      $model = new UnitGroup();

      if ($model->load(Yii::$app->request->post()) ) {	 
	  $divisionAr = $model->division_id;
	  print_r($divisionAr);
	 foreach($divisionAr as $division){
		 $modelOne = new UnitGroup();
		$modelOne->unit_id = $model->unit_id;
		 $modelOne->division_id =$division;			
		 $modelOne->save();
		 }	
		return $this->render('unit_group', [
                  'model' => $modelOne,
      ]); 
      }

      return $this->render('unit_group', [
                  'model' => $model,
      ]);
   }

   public function actionGroupUpdate($id)
	{
	 $model = new UnitGroup();
  if($model->load(Yii::$app->request->post()))
    {
		$deleteModel = UnitGroup::find()->Where(['unit_id'=>$id])->all();
		 foreach($deleteModel as $delModel){
		  $delModel->delete();
		 }
         $unitAr = $model->division_id;
		 foreach($unitAr as $unit){
		 $modelOne = new UnitGroup();				
		 $modelOne->unit_id =$id;
		 $modelOne->division_id = $unit;	
		 $modelOne->save();
		 }	 
		 return $this->redirect(['group-index']);
    } 
    return $this->render('editunit_group',[
	'model'=>$model,
	]); 
  }
  

   public function actionGroupDelete($id) {
       $deleteModel = UnitGroup::find()->Where(['unit_id'=>$id])->all();
		 foreach($deleteModel as $delModel){
		  $delModel->delete();
		 }
		//$model = Vgunit::findOne($id)->delete();

      return $this->redirect(['group-index']);
   }
   
   public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
                  'model' => $model,
      ]);
   }
   
    public function actionDivisionUpdate($id) {
      $model = Division::findOne($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['index']);
      }

      return $this->render('division_form', [
                  'model' => $model,
      ]);
   }

    public function actionDivisionDelete($id) {
      Division::findOne($id)->delete();
      return $this->redirect(['index']);
   }
   
   public function actionDelete($id) {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   /**
    * Finds the Unit model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Unit the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id) {
      if (($model = Unit::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }

}
