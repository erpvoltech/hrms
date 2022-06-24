<?php

namespace backend\controllers;

use Yii;
use DateTime;
use yii\helpers\Html;
use app\models\VgGpaPolicy;
use app\models\VgGpaPolicySearch;
use app\models\VgGpaHierarchy;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\AuthAssignment;

/**
 * VgGpaPolicyController implements the CRUD actions for VgGpaPolicy model.
 */
class VgGpaPolicyController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all VgGpaPolicy models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VgGpaPolicySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgGpaPolicy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $gpaModel = VgGpaPolicy::find()->where(['id' => $id])->one();
        $gpaItem = VgGpaHierarchy::find()->where(['gpa_policy_id' => $gpaModel->id])->all();

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'gpaItem' => $gpaItem,
        ]);
    }

    public function actionGpaannexure($id) {
        $gpaModel = VgGpaPolicy::find()->where(['policy_no' => $id])->one();
        $statuory = EmpStatutorydetails::find()->where(['gpa_no' => $gpaModel->policy_no])->all();
        return $this->render('gpaannexure', ['statuory' => $statuory,]);
    }

    /* public function actionUninsuredlistgpa() {
      //$gpaModel = VgGpaPolicy::find()->where(['policy_no' => $id])->one();
      $uninsured = EmpStatutorydetails::find()
      ->where(['IN', 'gpa_no', ['']])
      ->orWhere(['IS', 'gpa_no', NULL])
      ->all();
      return $this->render('uninsuredlistgpa', ['uninsured' => $uninsured,]);
      } */
    
    public function actionUninsuredindex(){
        return $this->render('uninsuredindex');
    }
    
    public function actionRelievedindexgpa(){
        return $this->render('relievedindexgpa');
    }
    
    public function actionGpaannexureindex(){
        return $this->render('gpaannexureindex');
    }

    public function actionUninsuredlistgpa() {
        $query = EmpStatutorydetails::find()
                ->where(['IN', 'gpa_no', ['']])
                ->orWhere(['IS', 'gpa_no', NULL]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('uninsuredlistgpa', [
                    'models' => $models,
                    'pages' => $pages,
        ]);
    }
        
    /// Export to Excel ///
    
    public function actionExportgpaannexdata($id) {
        $gpaModel = VgGpaPolicy::find()->where(['policy_no' => $id])->one();
        $statuory = EmpStatutorydetails::find()->where(['gpa_no' => $gpaModel->policy_no])->all();
        return $this->render('exportgpaannexdata', ['statuory' => $statuory,]);       
    }
    
    /**
     * Creates a new VgGpaPolicy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /* public function actionCreate()
      {
      $model = new VgGpaPolicy();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      } */

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

    /* public function actionEndorsementhierarchy($id){
      $endorsementHierarchy = VgGpaEndorsementHierarchy::find()->where(['gpa_endorsement_id' => $id])->all();
      return $this->render('endorsementhierarchy', ['endorsementHierarchy' => $endorsementHierarchy,]);
      } */

    public function actionCreate() {
        $vitalPolicy = new VgGpaPolicy;
        $modelHierarchy = [new VgGpaHierarchy];

        if ($vitalPolicy->load(Yii::$app->request->post())) {
            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");

            $modelHierarchy = Model::createMultiple(VgGpaHierarchy::classname());
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $vitalPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $vitalPolicy->save(false)) {
                        foreach ($modelHierarchy as $hierarchyAmt) {
                            $hierarchyAmt->gpa_policy_id = $vitalPolicy->id;
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
                    'modelHierarchy' => (empty($modelHierarchy)) ? [new VgGpaHierarchy] : $modelHierarchy
        ]);
    }

    /**
     * Updates an existing VgGpaPolicy model.
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
        $vitalPolicy = VgGpaPolicy::find()->where(['id' => $id])->one();

        $existingGpaId = VgGpaHierarchy::find()->select('id')->where(['gpa_policy_id' => $id])->asArray()->all();
        $existingGpaId = ArrayHelper::getColumn($existingGpaId, 'id');

        $modelHierarchy = VgGpaHierarchy::findAll(['id' => $existingGpaId]);
        $modelHierarchy = (empty($modelHierarchy)) ? [new VgGpaHierarchy] : $modelHierarchy;

        $post = Yii::$app->request->post();
        if ($vitalPolicy->load($post)) {

            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");

            $modelHierarchy = Model::createMultiple(VgGpaHierarchy::classname(), $modelHierarchy);
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());
            $newGpaId = ArrayHelper::getColumn($modelHierarchy, 'id');
            //print_r($newGpaId);

            $delGpaIds = array_diff($existingGpaId, $newGpaId);
            if (!empty($delGpaIds))
                VgGpaHierarchy::deleteAll(['id' => $delGpaIds]);

            $valid = $vitalPolicy->validate();
            // $valid = Model::validateMultiple($modelGpaItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $vitalPolicy->id = $id;
                    if ($flag = $vitalPolicy->save(false)) {

                        foreach ($modelHierarchy as $modelGpaItem) {
                            $modelGpaItem->gpa_policy_id = $vitalPolicy->id;
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
                        'modelHierarchy' => (empty($modelHierarchy)) ? [new VgGpaHierarchy] : $modelHierarchy,
            ]);
        }
    }

    /**
     * Deletes an existing VgGpaPolicy model.
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
     * Finds the VgGpaPolicy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgGpaPolicy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VgGpaPolicy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
