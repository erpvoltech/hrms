<?php

namespace backend\controllers;

use Yii;
use app\models\VeplStationariesIssue;
use app\models\VeplStationariesIssueSearch;
use app\models\VeplStationariesIssueSub;
use app\models\VeplStationariesGrnItem;
use app\models\VeplStationariesStock;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm; 

/**
 * VeplStationariesIssueController implements the CRUD actions for VeplStationariesIssue model.
 */
class VeplStationariesIssueController extends Controller {

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
     * Lists all VeplStationariesIssue models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VeplStationariesIssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VeplStationariesIssue model.
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

        $itemIssueModel = VeplStationariesIssue::find()->where(['id' => $id])->one();
        $issueItem = VeplStationariesIssueSub::find()->where(['issue_id' => $itemIssueModel->id])->all();

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'issueItem' => $issueItem,
        ]);
    }

    public function actionStockqty($id, $index) {
        $stock = VeplStationariesStock::find()->where(['item_id' => $id])->one();
        $arr = array('index' => $index, 'qty' => $stock->balance_qty);
        echo json_encode($arr);
    }

    public function actionStockqtycreate($id) {
        $stock = VeplStationariesStock::find()->where(['item_id' => $id])->one();
        echo $stock->balance_qty;
    }

    /**
     * Creates a new VeplStationariesIssue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /* public function actionCreate()
      {
      $model = new VeplStationariesIssue();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      } */

    public function actionCreate() {
        $modelGrn = new VeplStationariesIssue;
        $modelsGrnItem = [new VeplStationariesIssueSub];

        if ($modelGrn->load(Yii::$app->request->post())) {
            $modelGrn->issue_date = Yii::$app->formatter->asDate($modelGrn->issue_date, "yyyy-MM-dd");

            $modelsGrnItem = Model::createMultiple(VeplStationariesIssueSub::classname());
            Model::loadMultiple($modelsGrnItem, Yii::$app->request->post());

            // validate all models
            $valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelGrn->save(false)) {
                        foreach ($modelsGrnItem as $modelGrnItem) {
                            $modelGrnItem->issue_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->issue_item_id])->one();

                            if ($stock) {
                                $stockmodel = VeplStationariesStock::findOne($stock->id);
                                $stockmodel->balance_qty = $stock->balance_qty - $modelGrnItem->issued_qty;
                            } else {
                                $stockmodel = new VeplStationariesStock();
                                $stockmodel->item_id = $modelGrnItem->issue_item_id;
                                $stockmodel->balance_qty = $modelGrnItem->issued_qty;
                            }
                            $flag = $stockmodel->save(false);
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
                    'modelsGrnItem' => (empty($modelsGrnItem)) ? [new VeplStationariesIssueSub] : $modelsGrnItem
        ]);
    }

    /**
     * Updates an existing VeplStationariesIssue model.
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

    /*public function actionUpdate($id) {
        
        $modelGrn = VeplStationariesIssue::find()->where(['id' => $id])->one();

        $existingGrnId = VeplStationariesIssueSub::find()->select('id')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnId = ArrayHelper::getColumn($existingGrnId, 'id');

        $existingGrnItem = VeplStationariesIssueSub::find()->select('issued_qty')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnItem = ArrayHelper::getColumn($existingGrnItem, 'issued_qty');

        $existingGrnItemId = VeplStationariesIssueSub::find()->select('issue_item_id')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnItemId = ArrayHelper::getColumn($existingGrnItemId, 'issue_item_id');

        $modelGrnItems = VeplStationariesIssueSub::findAll(['id' => $existingGrnId]);
        $modelGrnItems = (empty($modelGrnItems)) ? [new VeplStationariesIssueSub] : $modelGrnItems;

        $post = Yii::$app->request->post();
        if ($modelGrn->load($post)) {

            foreach ($existingGrnItemId as $key => $value) {
                $stockDel = VeplStationariesStock::find()->where(['item_id' => $value])->one();
                $stockDel->balance_qty = $stockDel->balance_qty - $existingGrnItem[$key];
                $stockDel->save(false);
            }

            $modelGrn->issue_date = Yii::$app->formatter->asDate($modelGrn->issue_date, "yyyy-MM-dd");

            $modelGrnItems = Model::createMultiple(VeplStationariesIssueSub::classname(), $modelGrnItems);
            Model::loadMultiple($modelGrnItems, Yii::$app->request->post());
            $newGrnId = ArrayHelper::getColumn($modelGrnItems, 'id');
            //print_r($newGrnId);

            $delGrnIds = array_diff($existingGrnId, $newGrnId);
            if (!empty($delGrnIds))
                VeplStationariesIssueSub::deleteAll(['id' => $delGrnIds]);

            $valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelGrnItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $modelGrn->id = $id;
                    if ($flag = $modelGrn->save(false)) {

                        foreach ($modelGrnItems as $modelGrnItem) {
                            $modelGrnItem->issued_qty;
                            $modelGrnItem->issue_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->issue_item_id])->one();

                            if ($stock) {
                                $stockmodel = VeplStationariesStock::findOne($stock->id);
                                $stockmodel->balance_qty = $stock->balance_qty + $modelGrnItem->issued_qty;
                            } else {
                                $stockmodel = new VeplStationariesStock();
                                $stockmodel->item_id = $modelGrnItem->issue_item_id;
                                $stockmodel->balance_qty = $modelGrnItem->issued_qty;
                            }
                            $flag = $stockmodel->save(false);
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
                        'modelGrn' => $modelGrn,
                        'modelsGrnItem' => (empty($modelGrnItems)) ? [new VeplStationariesIssueSub] : $modelGrnItems,
            ]);
        }
    }*/
	
	public function actionUpdate($id) {

        $modelGrn = VeplStationariesIssue::find()->where(['id' => $id])->one();

        $existingGrnId = VeplStationariesIssueSub::find()->select('id')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnId = ArrayHelper::getColumn($existingGrnId, 'id');

        $existingGrnItem = VeplStationariesIssueSub::find()->select('issued_qty')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnItem = ArrayHelper::getColumn($existingGrnItem, 'issued_qty');

        $existingGrnItemId = VeplStationariesIssueSub::find()->select('issue_item_id')->where(['issue_id' => $id])->asArray()->all();
        $existingGrnItemId = ArrayHelper::getColumn($existingGrnItemId, 'issue_item_id');

        $modelGrnItems = VeplStationariesIssueSub::findAll(['id' => $existingGrnId]);
        $modelGrnItems = (empty($modelGrnItems)) ? [new VeplStationariesIssueSub] : $modelGrnItems;

        $post = Yii::$app->request->post();
        if ($modelGrn->load($post)) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($existingGrnItemId as $key => $value) {
                    $stockDel = VeplStationariesStock::find()->where(['item_id' => $value])->one();
                    $stockDel->balance_qty = $stockDel->balance_qty + $existingGrnItem[$key];
                    $stockDel->save(false);
                }

                $modelGrn->issue_date = Yii::$app->formatter->asDate($modelGrn->issue_date, "yyyy-MM-dd");

                $modelGrnItems = Model::createMultiple(VeplStationariesIssueSub::classname(), $modelGrnItems);
                Model::loadMultiple($modelGrnItems, Yii::$app->request->post());
                $newGrnId = ArrayHelper::getColumn($modelGrnItems, 'id');
                //print_r($newGrnId);

                $delGrnIds = array_diff($existingGrnId, $newGrnId);
                if (!empty($delGrnIds))
                    VeplStationariesIssueSub::deleteAll(['id' => $delGrnIds]);

                $valid = $modelGrn->validate();
                // $valid = Model::validateMultiple($modelGrnItems) && $valid;

                if ($valid) {

                    $modelGrn->id = $id;
                    if ($flag = $modelGrn->save(false)) {

                        foreach ($modelGrnItems as $modelGrnItem) {
                            $modelGrnItem->issued_qty;
                            $modelGrnItem->issue_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->issue_item_id])->one();

                            if ($stock) {
                                $stockmodel = VeplStationariesStock::findOne($stock->id);
                                $stockmodel->balance_qty = $stock->balance_qty - $modelGrnItem->issued_qty;
                            } else {
                                $stockmodel = new VeplStationariesStock();
                                $stockmodel->item_id = $modelGrnItem->issue_item_id;
                                $stockmodel->balance_qty = $modelGrnItem->issued_qty;
                            }
                            $flag = $stockmodel->save(false);
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                        'modelGrn' => $modelGrn,
                        'modelsGrnItem' => (empty($modelGrnItems)) ? [new VeplStationariesIssueSub] : $modelGrnItems,
            ]);
        }
    }

    /**
     * Deletes an existing VeplStationariesIssue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    /*public function actionCreatePopup()
    {
        $model = new VeplStationariesIssueSub();
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_stationaryReturn', [
                'model' => $model,
            ]);
        }
    }*/

    
    /**
     * Finds the VeplStationariesIssue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeplStationariesIssue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VeplStationariesIssue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
