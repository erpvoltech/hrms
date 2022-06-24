<?php

namespace backend\controllers;

use Yii;
use app\models\VeplStationariesPo;
use app\models\VeplStationariesPoSearch;
use app\models\VeplStationariesPoSub;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;

/**
 * VeplStationariesPoController implements the CRUD actions for VeplStationariesPo model.
 */
class VeplStationariesPoController extends Controller {

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
     * Lists all VeplStationariesPo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VeplStationariesPoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionPodownload($id) {
        $model = VeplStationariesPo::find()->where(['id' => $id])->one();
        
        $stationaryItem = VeplStationariesPoSub::find()->where(['po_id' => $model->id])->all();

        $content = $this->renderPartial('podownload', [ 'model' => $model, 'stationaryItem' => $stationaryItem,]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
        ]);
    }

    /**
     * Displays a single VeplStationariesPo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionView($id)
      {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      } */

    public function actionView($id) {
        $grnModel = VeplStationariesPo::find()->where(['id' => $id])->one();

        $grnItem = VeplStationariesPoSub::find()->where(['po_id' => $grnModel->id])->all();


        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'grnItem' => $grnItem,
        ]);
    }

    /**
     * Creates a new VeplStationariesPo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /* public function actionCreate()
      {
      $model = new VeplStationariesPo();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      } */

    public function actionCreate() {
        $modelGrn = new VeplStationariesPo;
        $modelsGrnItem = [new VeplStationariesPoSub];

        if ($modelGrn->load(Yii::$app->request->post())) {
            $modelGrn->po_date = Yii::$app->formatter->asDate($modelGrn->po_date, "yyyy-MM-dd");
            $modelGrn->last_purchase_date = Yii::$app->formatter->asDate($modelGrn->last_purchase_date, "yyyy-MM-dd");

            $modelsGrnItem = Model::createMultiple(VeplStationariesPoSub::classname());
            Model::loadMultiple($modelsGrnItem, Yii::$app->request->post());

            // validate all models
            $valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                     $tot = 0;
                     foreach ($modelsGrnItem as $modelItem) {
                         $tot += $modelItem->po_amount;                         
                     }
                    $modelGrn->po_prepared_by = Yii::$app->user->id;
                    $modelGrn->po_total_amount = $tot;
                    $modelGrn->po_net_amount = $modelGrn->po_total_amount + ($modelGrn->po_total_amount * ($modelGrn->po_sgst/100))+ ($modelGrn->po_total_amount * ($modelGrn->po_cgst/100));                    
                    if ($flag = $modelGrn->save(false)) {
                        foreach ($modelsGrnItem as $modelGrnItem) {
                            $modelGrnItem->po_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            /* $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->item_id])->one();

                              if ($stock) {
                              $stockmodel = VeplStationariesStock::findOne($stock->id);
                              $stockmodel->balance_qty = $stock->balance_qty + $modelGrnItem->quantity;
                              } else {
                              $stockmodel = new VeplStationariesStock();
                              $stockmodel->item_id = $modelGrnItem->item_id;
                              $stockmodel->balance_qty = $modelGrnItem->quantity;
                              }
                              $flag = $stockmodel->save(false); */
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelGrn->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                    'modelGrn' => $modelGrn,
                    'modelsGrnItem' => (empty($modelsGrnItem)) ? [new VeplStationariesPoSub] : $modelsGrnItem
        ]);
    }

    /**
     * Updates an existing VeplStationariesPo model.
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

    public function actionApprove($id) {
        $modelGrn = VeplStationariesPo::find()->where(['id' => $id])->one();
        $modelGrn->po_approval_status = 1;
        $modelGrn->po_approved_by = Yii::$app->user->id;
        if ($modelGrn->save(false))
            return $this->redirect(['view', 'id' => $id]);
        else
            echo 'something error';
    }

    public function actionUpdate($id) {
        $modelGrn = VeplStationariesPo::find()->where(['id' => $id])->one();

        $existingGrnId = VeplStationariesPoSub::find()->select('id')->where(['po_id' => $id])->asArray()->all();
        $existingGrnId = ArrayHelper::getColumn($existingGrnId, 'id');

        $existingGrnItem = VeplStationariesPoSub::find()->select('po_qty')->where(['po_id' => $id])->asArray()->all();
        $existingGrnItem = ArrayHelper::getColumn($existingGrnItem, 'po_qty');

        $existingGrnItemId = VeplStationariesPoSub::find()->select('po_item_id')->where(['po_id' => $id])->asArray()->all();
        $existingGrnItemId = ArrayHelper::getColumn($existingGrnItemId, 'po_item_id');


        $modelGrnItems = VeplStationariesPoSub::findAll(['id' => $existingGrnId]);
        $modelGrnItems = (empty($modelGrnItems)) ? [new VeplStationariesPoSub] : $modelGrnItems;
       
        $post = Yii::$app->request->post();
        if ($modelGrn->load($post)) {

            /* foreach($existingGrnItemId as $key => $value){                
              $stockDel = VeplStationariesStock::find()->where(['item_id' =>$value])->one();
              $stockDel->balance_qty = $stockDel->balance_qty - $existingGrnItem[$key];
              $stockDel->save(false);
              } */

            $modelGrn->po_date = Yii::$app->formatter->asDate($modelGrn->po_date, "yyyy-MM-dd");
            $modelGrn->last_purchase_date = Yii::$app->formatter->asDate($modelGrn->last_purchase_date, "yyyy-MM-dd");
            
            $modelGrnItems = Model::createMultiple(VeplStationariesPoSub::classname(), $modelGrnItems);
            Model::loadMultiple($modelGrnItems, Yii::$app->request->post());
            $newGrnId = ArrayHelper::getColumn($modelGrnItems, 'id');
            //print_r($newGrnId);

            $delGrnIds = array_diff($existingGrnId, $newGrnId);
            if (!empty($delGrnIds))
                VeplStationariesPoSub::deleteAll(['id' => $delGrnIds]);

            //$valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelGrnItems) && $valid;

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $modelGrn->id = $id;
                    $tot = 0;
                     foreach ($modelGrnItems as $modelItem) {
                         $tot += $modelItem->po_amount;                         
                     }                   
                    $modelGrn->po_prepared_by = Yii::$app->user->id;
                    $modelGrn->po_total_amount = $tot;
                    $modelGrn->po_net_amount = $modelGrn->po_total_amount + ($modelGrn->po_total_amount * ($modelGrn->po_sgst/100))+ ($modelGrn->po_total_amount * ($modelGrn->po_cgst/100));                    
                   
                    if ($flag = $modelGrn->save(false)) {

                        foreach ($modelGrnItems as $modelGrnItem) {
                            $modelGrnItem->po_qty;
                            $modelGrnItem->po_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
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
            
        } else {
            return $this->render('update', [
                        'modelGrn' => $modelGrn,
                        'modelsGrnItem' => (empty($modelGrnItems)) ? [new VeplStationariesPoSub] : $modelGrnItems,
            ]);
        }
    }

    /**
     * Deletes an existing VeplStationariesPo model.
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
     * Finds the VeplStationariesPo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeplStationariesPo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VeplStationariesPo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
