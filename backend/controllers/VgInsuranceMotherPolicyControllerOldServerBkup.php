<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use app\models\VgInsuranceMotherPolicy;
use app\models\VgInsuranceMotherPolicySearch;
use app\models\VgInsuranceHierarchy;
use app\models\VgInsurancePolicy;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * VgInsuranceMotherPolicyController implements the CRUD actions for VgInsuranceMotherPolicy model.
 */
class VgInsuranceMotherPolicyController extends Controller
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
     * Lists all VgInsuranceMotherPolicy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VgInsuranceMotherPolicySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgInsuranceMotherPolicy model.
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
     * Creates a new VgInsuranceMotherPolicy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
        
    public function actionPolicydata($id) {
        $policyModel = VgInsurancePolicy::find()->where(['id' => $id])->one();
        $motherPolicy = VgInsuranceMotherPolicy::find()->where(['policy_for_id' => $policyModel->id])->all();
        

        return $this->render('policydata', [
                    'model' => $policyModel,
                    'motherPolicy' => $motherPolicy,
        ]);
    }
    
    public function actionPolicytype() {
        $model = new VgInsurancePolicy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //   return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('policytype', [
                        'model' => $model,
            ]);
        }
    }
    
    public function actionPolicystore() {
        $model = new VgInsurancePolicy();
        return $this->renderAjax('policystore', [
                    'model' => $model,
        ]);
    }
    
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
    
    public function actionCreate() {
        $vitalPolicy = new VgInsuranceMotherPolicy;
        $modelHierarchy = [new VgInsuranceHierarchy];

        if ($vitalPolicy->load(Yii::$app->request->post())) {
            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");
            
            $modelHierarchy = Model::createMultiple(VgInsuranceHierarchy::classname());
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $vitalPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    
                    if ($flag = $vitalPolicy->save(false)) {
                        foreach ($modelHierarchy as $hierarchyAmt) {
                            $hierarchyAmt->master_policy_id = $vitalPolicy->id;
                            if (!($flag = $hierarchyAmt->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['/vg-insurance-agents/index']);//, 'id' => $vitalPolicy->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'vitalPolicy' => $vitalPolicy,
                    'modelHierarchy' => (empty($modelHierarchy)) ? [new VgInsuranceHierarchy] : $modelHierarchy
        ]);
    }

    /**
     * Updates an existing VgInsuranceMotherPolicy model.
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
     * Deletes an existing VgInsuranceMotherPolicy model.
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
     * Finds the VgInsuranceMotherPolicy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgInsuranceMotherPolicy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VgInsuranceMotherPolicy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
