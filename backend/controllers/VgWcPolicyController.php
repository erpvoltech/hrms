<?php

namespace backend\controllers;

use Yii;
use DateTime;
use yii\helpers\Html;
use app\models\VgWcPolicy;
use app\models\VgWcPolicySearch;
use app\models\VgWcHierarchy;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * VgWcPolicyController implements the CRUD actions for VgWcPolicy model.
 */
class VgWcPolicyController extends Controller
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
     * Lists all VgWcPolicy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VgWcPolicySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgWcPolicy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $wcModel = VgWcPolicy::find()->where(['id' => $id])->one();
        $wcItem = VgWcHierarchy::find()->where(['wc_id' => $wcModel->id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'wcItem' => $wcItem,
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

    /**
     * Creates a new VgWcPolicy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new VgWcPolicy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/
    
    public function actionCreate() {
        $vitalPolicy = new VgWcPolicy;
        $modelHierarchy = [new VgWcHierarchy];

        if ($vitalPolicy->load(Yii::$app->request->post())) {
            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");
            
            $modelHierarchy = Model::createMultiple(VgWcHierarchy::classname());
            Model::loadMultiple($modelHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $vitalPolicy->validate();
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $vitalPolicy->save(false)) {
                        foreach ($modelHierarchy as $hierarchyAmt) {
                            $hierarchyAmt->wc_id = $vitalPolicy->id;
                            if (!($flag = $hierarchyAmt->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $vitalPolicy->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'vitalPolicy' => $vitalPolicy,
                    'modelHierarchy' => (empty($modelHierarchy)) ? [new VgWcHierarchy] : $modelHierarchy
        ]);
    }

    /**
     * Updates an existing VgWcPolicy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/
    
    public function actionUpdate($id) {
        $vitalPolicy = VgWcPolicy::find()->where(['id' => $id])->one();

        $existingGpaId = VgWcHierarchy::find()->select('id')->where(['wc_id' => $id])->asArray()->all();
        $existingGpaId = ArrayHelper::getColumn($existingGpaId, 'id');
       
        $modelHierarchy = VgWcHierarchy::findAll(['id' => $existingGpaId]);
        $modelHierarchy = (empty($modelHierarchy)) ? [new VgWcHierarchy] : $modelHierarchy;
       
        $post = Yii::$app->request->post();
        if ($vitalPolicy->load($post)) {
            
            $vitalPolicy->from_date = Yii::$app->formatter->asDate($vitalPolicy->from_date, "yyyy-MM-dd");
            $vitalPolicy->to_date = Yii::$app->formatter->asDate($vitalPolicy->to_date, "yyyy-MM-dd");
                      
            $modelHierarchy = Model::createMultiple(VgWcHierarchy::classname(), $modelHierarchy);
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
                            $modelGpaItem->wc_id = $vitalPolicy->id;
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
                        'modelHierarchy' => (empty($modelHierarchy)) ? [new VgWcHierarchy] : $modelHierarchy,
            ]);
        }
    }

    /**
     * Deletes an existing VgWcPolicy model.
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
     * Finds the VgWcPolicy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgWcPolicy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VgWcPolicy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
