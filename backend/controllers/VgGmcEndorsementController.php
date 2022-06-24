<?php

namespace backend\controllers;

use Yii;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementSearch;
use app\models\VgGmcEndorsementHierarchy;
use app\models\VgGmcPolicy;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * VgGmcEndorsementController implements the CRUD actions for VgGmcEndorsement model.
 */
class VgGmcEndorsementController extends Controller
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
     * Lists all VgGmcEndorsement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VgGmcEndorsementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgGmcEndorsement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $gpaEndorseModel = VgGmcEndorsement::find()->where(['id' => $id])->one();
        $gpaEndorseItem = VgGmcEndorsementHierarchy::find()->where(['gmc_endorsement_id' => $gpaEndorseModel->id])->all();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'gpaEndorseItem' => $gpaEndorseItem,
        ]);
    }
    
    public function actionGmcendoannexure($id) {
        $gpaEndoModel = VgGmcEndorsement::find()->where(['endorsement_no' => $id])->one();
        $endoStatuory = EmpStatutorydetails::find()->where(['gmc_no' => $gpaEndoModel->endorsement_no])->all();
            return $this->render('gmcendoannexure',['endoStatuory' => $endoStatuory,]);  
    }
    
    /// Export to Excel ///
    
    public function actionExportgmcendoannexdata($id) {
        $gpaEndoModel = VgGmcEndorsement::find()->where(['endorsement_no' => $id])->one();
        $endoStatuory = EmpStatutorydetails::find()->where(['gmc_no' => $gpaEndoModel->endorsement_no])->all();
        return $this->render('exportgmcendoannexdata', ['endoStatuory' => $endoStatuory,]);       
    }

    /**
     * Creates a new VgGmcEndorsement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new VgGmcEndorsement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/
    
    public function actionCreate() {
        $endorsmentPolicy = new VgGmcEndorsement;
        $endorsmentHierarchy = [new VgGmcEndorsementHierarchy];

        if ($endorsmentPolicy->load(Yii::$app->request->post())) {
            
            $endorsmentPolicy->start_date = Yii::$app->formatter->asDate($endorsmentPolicy->start_date, "yyyy-MM-dd");
            $endorsmentPolicy->end_date = Yii::$app->formatter->asDate($endorsmentPolicy->end_date, "yyyy-MM-dd");
            
            $endorsmentHierarchy = Model::createMultiple(VgGmcEndorsementHierarchy::classname());
            Model::loadMultiple($endorsmentHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $endorsmentPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    $motherpolicy = VgGmcPolicy::find()->where(['policy_no'=>$endorsmentPolicy->gmc_mother_policy_id])->one();
                    $endorsmentPolicy->gmc_mother_policy_id = $motherpolicy->id;
                    if ($flag = $endorsmentPolicy->save(false)) {
                        foreach ($endorsmentHierarchy as $hierarchyAmt) {                           
                            $hierarchyAmt->gmc_endorsement_id = $endorsmentPolicy->id;
                            if (!($flag = $hierarchyAmt->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $endorsmentPolicy->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'endorsmentPolicy' => $endorsmentPolicy,
                    'endorsmentHierarchy' => (empty($endorsmentHierarchy)) ? [new VgGmcEndorsementHierarchy] : $endorsmentHierarchy
        ]);
    }

    /**
     * Updates an existing VgGmcEndorsement model.
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
        $endorsmentPolicy = VgGmcEndorsement::find()->where(['id' => $id])->one();

        $existingGpaId = VgGmcEndorsementHierarchy::find()->select('id')->where(['gmc_endorsement_id' => $id])->asArray()->all();
        $existingGpaId = ArrayHelper::getColumn($existingGpaId, 'id');
       
        $endorsmentHierarchy = VgGmcEndorsementHierarchy::findAll(['id' => $existingGpaId]);
        $endorsmentHierarchy = (empty($endorsmentHierarchy)) ? [new VgGmcEndorsementHierarchy] : $endorsmentHierarchy;
       
        $post = Yii::$app->request->post();
        if ($endorsmentPolicy->load($post)) {
                      
            $endorsmentPolicy->start_date = Yii::$app->formatter->asDate($endorsmentPolicy->start_date, "yyyy-MM-dd");
            $endorsmentPolicy->end_date = Yii::$app->formatter->asDate($endorsmentPolicy->end_date, "yyyy-MM-dd");

            $endorsmentHierarchy = Model::createMultiple(VgGmcEndorsementHierarchy::classname(), $endorsmentHierarchy);
            Model::loadMultiple($endorsmentHierarchy, Yii::$app->request->post());
            $newGpaId = ArrayHelper::getColumn($endorsmentHierarchy, 'id');
            //print_r($newGpaId);

            $delGpaIds = array_diff($existingGpaId, $newGpaId);
            if (!empty($delGpaIds))
                VgGmcEndorsementHierarchy::deleteAll(['id' => $delGpaIds]);

            $valid = $endorsmentPolicy->validate();
            // $valid = Model::validateMultiple($modelGpaItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $endorsmentPolicy->id = $id;
                    if ($flag = $endorsmentPolicy->save(false)) {

                        foreach ($endorsmentHierarchy as $modelGpaItem) {
                            $modelGpaItem->gmc_endorsement_id = $endorsmentPolicy->id;
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
                        'endorsmentPolicy' => $endorsmentPolicy,
                        'endorsmentHierarchy' => (empty($endorsmentHierarchy)) ? [new VgGmcEndorsementHierarchy] : $endorsmentHierarchy,
            ]);
        }
    }

    /**
     * Deletes an existing VgGmcEndorsement model.
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
     * Finds the VgGmcEndorsement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgGmcEndorsement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VgGmcEndorsement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
