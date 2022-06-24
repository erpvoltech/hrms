<?php

namespace backend\controllers;

use Yii;
use app\models\VgInsuranceEndorsement;
use app\models\VgInsuranceEndorsementClass;
use app\models\VgInsuranceMotherPolicy;
use app\models\VgInsuranceEndorsementHierarchy;
use yii\web\Controller;
use app\models\Model;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VgInsuranceEndorsementController implements the CRUD actions for VgInsuranceEndorsement model.
 */
class VgInsuranceEndorsementController extends Controller
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
     * Lists all VgInsuranceEndorsement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VgInsuranceEndorsementClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgInsuranceEndorsement model.
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
     * Creates a new VgInsuranceEndorsement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
        
    public function actionCreate() {
        $endorsmentPolicy = new VgInsuranceEndorsement;
        $endorsmentHierarchy = [new VgInsuranceEndorsementHierarchy];

        if ($endorsmentPolicy->load(Yii::$app->request->post())) {
            
            $endorsmentPolicy->start_date = Yii::$app->formatter->asDate($endorsmentPolicy->start_date, "yyyy-MM-dd");
            $endorsmentPolicy->end_date = Yii::$app->formatter->asDate($endorsmentPolicy->end_date, "yyyy-MM-dd");
            
            $endorsmentHierarchy = Model::createMultiple(VgInsuranceEndorsementHierarchy::classname());
            Model::loadMultiple($endorsmentHierarchy, Yii::$app->request->post());

            // validate all models
            $valid = $endorsmentPolicy->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    
                    if ($flag = $endorsmentPolicy->save(false)) {
                        foreach ($endorsmentHierarchy as $hierarchyAmt) {
                            $hierarchyAmt->endorsement_policy_id = $endorsmentPolicy->id;
                            if (!($flag = $hierarchyAmt->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['/vg-insurance-agents/index']);//, 'id' => $endorsmentPolicy->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'endorsmentPolicy' => $endorsmentPolicy,
                    'endorsmentHierarchy' => (empty($endorsmentHierarchy)) ? [new VgInsuranceEndorsementHierarchy] : $endorsmentHierarchy
        ]);
    }

    /**
     * Updates an existing VgInsuranceEndorsement model.
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
     * Deletes an existing VgInsuranceEndorsement model.
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
     * Finds the VgInsuranceEndorsement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgInsuranceEndorsement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VgInsuranceEndorsement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
