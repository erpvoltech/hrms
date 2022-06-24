<?php

namespace backend\controllers;

use Yii;
use DateTime;
use yii\helpers\Html;
use app\models\VgGmcPolicy;
use app\models\VgGmcPolicySearch;
use app\models\VgGmcHierarchy;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\CmdFamilyPolicy;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\Pagination;
use yii\filters\AccessControl;
use app\models\AuthAssignment;

/**
 * VgGmcPolicyController implements the CRUD actions for VgGmcPolicy model.
 */
class VgGmcPolicyController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['cmdindex','cmdview','cmdviewone'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('cmd family policy', 'view');
                        },
                        'roles' => ['@'],
                    ],
                      [
                        'allow' => true,
                        'actions' => ['cmdindex','cmdcreate','cmdview','cmdviewone','cmdupdate','cmddelete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('cmd family policy', 'create');
                        },
                        'roles' => ['@'],
                    ],
                    [
                      'allow' => true,
                      'actions' => ['index','view','create','update','delete','loadagents','gmcannexure','gmcannexureindex','exportgmcannexdata','uninsuredindexgmc','relievedindexgmc'],
                      'roles' => ['@'],
                  ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
					],
            ],
        ];
    }

    /**
     * Lists all VgGmcPolicy models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VgGmcPolicySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgGmcPolicy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $gmcModel = VgGmcPolicy::find()->where(['id' => $id])->one();
        $gmcItem = VgGmcHierarchy::find()->where(['gmc_policy_id' => $gmcModel->id])->all();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'gmcItem' => $gmcItem,
        ]);
    }

    /**
     * Creates a new VgGmcPolicy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLoadagents() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $comp_id = $parents[0];
                $out = self::Companyagents($comp_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
            }
        }
    }

    public function Companyagents($id) {
        $model = VgInsuranceAgents::find()->where(['company_id' => $id])->all();
        $compid = [];
        foreach ($model as $agents) {
            $compid [] = ['id' => $agents->id, 'name' => $agents->agent_name];
        }
        return $compid;
    }

    public function actionGmcannexure($id) {
        $gpaModel = VgGmcPolicy::find()->where(['policy_no' => $id])->one();
        $statuory = EmpStatutorydetails::find()->where(['gmc_no' => $gpaModel->policy_no])->all();
        return $this->render('gmcannexure', ['statuory' => $statuory,]);
    }
    
    public function actionGmcannexureindex(){
        return $this->render('gmcannexureindex');
    }
    
     /// Export to Excel ///
    
    public function actionExportgmcannexdata($id) {
        $gpaModel = VgGmcPolicy::find()->where(['policy_no' => $id])->one();
        $statuory = EmpStatutorydetails::find()->where(['gmc_no' => $gpaModel->policy_no])->all();
        return $this->render('exportgmcannexdata', ['statuory' => $statuory,]);       
    }

     public function actionUninsuredlistgmc() {
      //$gpaModel = VgGpaPolicy::find()->where(['policy_no' => $id])->one();
      $models = EmpStatutorydetails::find()
      ->where(['IN', 'gmc_no', ['']])
      ->orWhere(['IS', 'gmc_no', NULL])
      ->all();
      return $this->render('uninsuredlistgmc', ['models' => $models,]);
      } 
      
      public function actionUninsuredindexgmc(){
        return $this->render('uninsuredindexgmc');
    }
    
     public function actionRelievedindexgmc(){
        return $this->render('relievedindexgmc');
    }
//SELECT A.empid FROM `emp_remuneration_details` AS A JOIN emp_statutorydetails AS B ON A.empid=B.empid WHERE A.gross_salary >= 21000 AND B.gmc_no IS NULL OR B.gmc_no = '' 
    /*public function actionUninsuredlistgmc() {
        $query = EmpStatutorydetails::find()
                ->where(['IN', 'gmc_no', ['']])
                ->orWhere(['IS', 'gmc_no', NULL]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('uninsuredlistgmc', [
                    'models' => $models,
                    'pages' => $pages,
        ]);
    }*/

    /* public function actionCreate()
      {
      $model = new VgGmcPolicy();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      } */

    public function actionCreate() {
        $vitalPolicy = new VgGmcPolicy;
        $modelHierarchy = [new VgGmcHierarchy];

        if ($vitalPolicy->load(Yii::$app->request->post())) {
            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");

            $modelHierarchy = Model::createMultiple(VgGmcHierarchy::classname());
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $vitalPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $vitalPolicy->save(false)) {
                        foreach ($modelHierarchy as $hierarchyAmt) {
                            $hierarchyAmt->gmc_policy_id = $vitalPolicy->id;
                            if (!($flag = $hierarchyAmt->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $vitalPolicy->id]);
                        //return $this->redirect(['/vg-insurance-agents/index']); //, 'id' => $vitalPolicy->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'vitalPolicy' => $vitalPolicy,
                    'modelHierarchy' => (empty($modelHierarchy)) ? [new VgGmcHierarchy] : $modelHierarchy
        ]);
    }

    /**
     * Updates an existing VgGmcPolicy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionUpdate($id)
      {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
      'model' => $model,
      ]);
      } */

    public function actionUpdate($id) {
        $vitalPolicy = VgGmcPolicy::find()->where(['id' => $id])->one();

        $existingGpaId = VgGmcHierarchy::find()->select('id')->where(['gmc_policy_id' => $id])->asArray()->all();
        $existingGpaId = ArrayHelper::getColumn($existingGpaId, 'id');

        $modelHierarchy = VgGmcHierarchy::findAll(['id' => $existingGpaId]);
        $modelHierarchy = (empty($modelHierarchy)) ? [new VgGmcHierarchy] : $modelHierarchy;

        $post = Yii::$app->request->post();
        if ($vitalPolicy->load($post)) {

            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");

            $modelHierarchy = Model::createMultiple(VgGmcHierarchy::classname(), $modelHierarchy);
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());
            $newGpaId = ArrayHelper::getColumn($modelHierarchy, 'id');
            //print_r($newGpaId);

            $delGpaIds = array_diff($existingGpaId, $newGpaId);
            if (!empty($delGpaIds))
                VgGmcHierarchy::deleteAll(['id' => $delGpaIds]);

            $valid = $vitalPolicy->validate();
            // $valid = Model::validateMultiple($modelGpaItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $vitalPolicy->id = $id;
                    if ($flag = $vitalPolicy->save(false)) {

                        foreach ($modelHierarchy as $modelGpaItem) {
                            $modelGpaItem->gmc_policy_id = $vitalPolicy->id;
                            if (!($flag = $modelGpaItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
                        'vitalPolicy' => $vitalPolicy,
                        'modelHierarchy' => (empty($modelHierarchy)) ? [new VgGmcHierarchy] : $modelHierarchy,
            ]);
        }
    }

    /**
     * Deletes an existing VgGmcPolicy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VgGmcPolicy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgGmcPolicy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VgGmcPolicy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	//CMD Family Policy//

    public function actionCmdcreate()
    {
        $model = new CmdFamilyPolicy();

        if ($model->load(Yii::$app->request->post())) {
            $model->policy_date = Yii::$app->formatter->asDate($model->policy_date, "yyyy-MM-dd");
            $model->maturity_date = Yii::$app->formatter->asDate($model->maturity_date, "yyyy-MM-dd");
            $model->save();
            return $this->redirect(['cmdviewone', 'id' => $model->id]);
        }

        return $this->render('cmdcreate', [
            'model' => $model,
        ]);
    }

     public function actionCmdview($id) {
       $model =  CmdFamilyPolicy::findOne($id);
        return $this->render('cmdview', [
                    'model' => $model,
        ]);
    }

    public function actionCmdviewone($id) {
       $model =  CmdFamilyPolicy::findOne($id);
        return $this->render('cmdviewone', [
                    'model' => $model,
        ]);
    }

    public function actionCmdindex() {
        return $this->render('cmdindex');
    }

    public function actionCmdupdate($id)
    {
        $model = CmdFamilyPolicy::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->policy_date = Yii::$app->formatter->asDate($model->policy_date, "yyyy-MM-dd");
            $model->maturity_date = Yii::$app->formatter->asDate($model->maturity_date, "yyyy-MM-dd");
			if($model->policy_paid_date == ''){
            $model->policy_paid_date = NULL;
            }else{
            $model->policy_paid_date = Yii::$app->formatter->asDate($model->policy_paid_date, "yyyy-MM-dd");
            }
            $model->save();
            return $this->redirect(['cmdviewone', 'id' => $model->id]);
        }

        return $this->render('cmdupdate', [
            'model' => $model,
        ]);
    }

    public function actionCmddelete($id)
    {
        $model = CmdFamilyPolicy::findOne($id);

        $model->delete();

        return $this->redirect(['cmdindex']);
    }

    /*public function actionCmdpolicyreminder(){
        //$reminder = VgInsuranceBuilding::find()->where('valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')->all();
        return $this->render('cmdpolicyreminder');
    }*/
	//End of CMD Family Policy//

}
