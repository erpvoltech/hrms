<?php

namespace backend\controllers;

use Yii;
use app\models\VeplStationariesGrn;
use app\models\VeplStationariesGrnSearch;
use app\models\VeplStationariesStock;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VeplStationariesGrnController implements the CRUD actions for VeplStationariesGrn model.
 */
class VeplStationariesGrnController extends Controller {

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
     * Lists all VeplStationariesGrn models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VeplStationariesGrnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VeplStationariesGrn model.
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
     * Creates a new VeplStationariesGrn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate() {
        //$model = new VeplStationariesGrn();
        $modelsGrn = [new VeplStationariesGrn];
        if ($modelsGrn->load(Yii::$app->request->post())) {
            $modelsGrn->grn_date = Yii::$app->formatter->asDate($modelsGrn->grn_date, "yyyy-MM-dd");

            $stock = VeplStationariesStock::find()->where(['item_id' => $modelsGrn->item_id])->one();
            if ($stock) {
                $stockmodel = VeplStationariesStock::findOne($stock->id);
                $stockmodel->balance_qty = $stock->balance_qty + $modelsGrn->quantity;
            } else {
                $stockmodel = new VeplStationariesStock();
                $stockmodel->item_id = $modelsGrn->item_id;
                $stockmodel->balance_qty = $modelsGrn->quantity;
            }

            $modelsGrn->save();
            $stockmodel->save();
            return $this->redirect(['view', 'id' => $modelsGrn->id]);
        }

        return $this->render('create', [
                    'model' => $modelsGrn,
        ]);
    }*/
    
    
    public function actionCreate()
    {
        $modelStock = new VeplStationariesStock();
        $modelsGrn = [new VeplStationariesGrn];

        if ($modelStock->load(Yii::$app->request->post())) {

            $modelsGrn = Model::createMultiple(VeplStationariesGrn::classname());
            Model::loadMultiple($modelsGrn, Yii::$app->request->post());

            // validate all models
            $valid = $modelStock->validate();
            $valid = Model::validateMultiple($modelsGrn) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelStock->save(false)) {
                        foreach ($modelsGrn as $modelsGrn) {
                            $modelsGrn->customer_id = $modelStock->id;
                            if (! ($flag = $modelsGrn->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelStock->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelStock' => $modelStock,
            'modelsGrn' => (empty($modelsGrn)) ? [new VeplStationariesGrn] : $modelsGrn
        ]);
    }


    /**
     * Updates an existing VeplStationariesGrn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->grn_date = Yii::$app->formatter->asDate($model->grn_date, "yyyy-MM-dd");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VeplStationariesGrn model.
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
     * Finds the VeplStationariesGrn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeplStationariesGrn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VeplStationariesGrn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
