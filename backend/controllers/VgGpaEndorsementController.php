<?php

namespace backend\controllers;

use Yii;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementSearch;
use app\models\VgGpaEndorsementHierarchy;
use app\models\VgGpaPolicy;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * VgGpaEndorsementController implements the CRUD actions for VgGpaEndorsement model.
 */
class VgGpaEndorsementController extends Controller
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
     * Lists all VgGpaEndorsement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VgGpaEndorsementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgGpaEndorsement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $gpaEndorseModel = VgGpaEndorsement::find()->where(['id' => $id])->one();
        $gpaEndorseItem = VgGpaEndorsementHierarchy::find()->where(['gpa_endorsement_id' => $gpaEndorseModel->id])->all();
               
        return $this->render('view', [
            'model' => $this->findModel($id),
            'gpaEndorseItem' => $gpaEndorseItem,
        ]);
    }

    public function actionEndorsementhierarchy($id){
        $endorsementHierarchy = VgGpaEndorsementHierarchy::find()->where(['gpa_endorsement_id' => $id])->all();
        return $this->render('endorsementhierarchy', ['endorsementHierarchy' => $endorsementHierarchy,]);
    }
    
    public function actionGpaendoannexure($id) {
        $gpaEndoModel = VgGpaEndorsement::find()->where(['endorsement_no' => $id])->one();
        $endoStatuory = EmpStatutorydetails::find()->where(['gpa_no' => $gpaEndoModel->endorsement_no])->all();
            return $this->render('gpaendoannexure',['endoStatuory' => $endoStatuory,]);  
    }
    
    /// Export to Excel ///
    
    public function actionExportgpaendoannexdata($id) {
        $gpaEndoModel = VgGpaEndorsement::find()->where(['endorsement_no' => $id])->one();
        $endoStatuory = EmpStatutorydetails::find()->where(['gpa_no' => $gpaEndoModel->endorsement_no])->all();
        return $this->render('exportgpaendoannexdata', ['endoStatuory' => $endoStatuory,]);       
    }
    
    /**
     * Creates a new VgGpaEndorsement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new VgGpaEndorsement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/
    
    public function actionCreate() {
        $endorsmentPolicy = new VgGpaEndorsement;
        $endorsmentHierarchy = [new VgGpaEndorsementHierarchy];

        if ($endorsmentPolicy->load(Yii::$app->request->post())) {
            
            $endorsmentPolicy->start_date = Yii::$app->formatter->asDate($endorsmentPolicy->start_date, "yyyy-MM-dd");
            $endorsmentPolicy->end_date = Yii::$app->formatter->asDate($endorsmentPolicy->end_date, "yyyy-MM-dd");
            
            $endorsmentHierarchy = Model::createMultiple(VgGpaEndorsementHierarchy::classname());
            Model::loadMultiple($endorsmentHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $endorsmentPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    $motherpolicy = VgGpaPolicy::find()->where(['policy_no'=>$endorsmentPolicy->gpa_mother_policy_id])->one();
                    $endorsmentPolicy->gpa_mother_policy_id = $motherpolicy->id;
                    if ($flag = $endorsmentPolicy->save(false)) {
                        foreach ($endorsmentHierarchy as $hierarchyAmt) {                           
                            $hierarchyAmt->gpa_endorsement_id = $endorsmentPolicy->id;
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
                    'endorsmentHierarchy' => (empty($endorsmentHierarchy)) ? [new VgGpaEndorsementHierarchy] : $endorsmentHierarchy
        ]);
    }

    /**
     * Updates an existing VgGpaEndorsement model.
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
    //$endorsmentPolicy
    //$endorsmentHierarchy
    public function actionUpdate($id) {
        $endorsmentPolicy = VgGpaEndorsement::find()->where(['id' => $id])->one();

        $existingGpaId = VgGpaEndorsementHierarchy::find()->select('id')->where(['gpa_endorsement_id' => $id])->asArray()->all();
        $existingGpaId = ArrayHelper::getColumn($existingGpaId, 'id');
       
        $endorsmentHierarchy = VgGpaEndorsementHierarchy::findAll(['id' => $existingGpaId]);
        $endorsmentHierarchy = (empty($endorsmentHierarchy)) ? [new VgGpaEndorsementHierarchy] : $endorsmentHierarchy;
       
        $post = Yii::$app->request->post();
        if ($endorsmentPolicy->load($post)) {
                      
            $endorsmentPolicy->start_date = Yii::$app->formatter->asDate($endorsmentPolicy->start_date, "yyyy-MM-dd");
            $endorsmentPolicy->end_date = Yii::$app->formatter->asDate($endorsmentPolicy->end_date, "yyyy-MM-dd");

            $endorsmentHierarchy = Model::createMultiple(VgGpaEndorsementHierarchy::classname(), $endorsmentHierarchy);
            Model::loadMultiple($endorsmentHierarchy, Yii::$app->request->post());
            $newGpaId = ArrayHelper::getColumn($endorsmentHierarchy, 'id');
            //print_r($newGpaId);

            $delGpaIds = array_diff($existingGpaId, $newGpaId);
            if (!empty($delGpaIds))
                VgGpaEndorsementHierarchy::deleteAll(['id' => $delGpaIds]);

            $valid = $endorsmentPolicy->validate();
            // $valid = Model::validateMultiple($modelGpaItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $endorsmentPolicy->id = $id;
                    if ($flag = $endorsmentPolicy->save(false)) {

                        foreach ($endorsmentHierarchy as $modelGpaItem) {
                            $modelGpaItem->gpa_endorsement_id = $endorsmentPolicy->id;
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
                        'endorsmentHierarchy' => (empty($endorsmentHierarchy)) ? [new VgGpaEndorsementHierarchy] : $endorsmentHierarchy,
            ]);
        }
    }

    /**
     * Deletes an existing VgGpaEndorsement model.
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
     * Finds the VgGpaEndorsement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgGpaEndorsement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VgGpaEndorsement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
