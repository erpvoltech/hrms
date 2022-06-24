<?php

namespace backend\controllers;

use Yii;
use app\models\VeplStationariesGrn;
use app\models\VeplStationariesGrnSearch;
use app\models\VeplStationariesGrnItem;
use app\models\VeplStationariesStock;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        $grnModel = VeplStationariesGrn::find()->where(['id' => $id])->one();

        $grnItem = VeplStationariesGrnItem::find()->where(['grn_id' => $grnModel->id])->all();


        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'grnItem' => $grnItem,
        ]);
    }

    /**
     * Creates a new VeplStationariesGrn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelGrn = new VeplStationariesGrn;
        $modelsGrnItem = [new VeplStationariesGrnItem];

        if ($modelGrn->load(Yii::$app->request->post())) {
            $modelGrn->grn_date = Yii::$app->formatter->asDate($modelGrn->grn_date, "yyyy-MM-dd");

            $modelsGrnItem = Model::createMultiple(VeplStationariesGrnItem::classname());
            Model::loadMultiple($modelsGrnItem, Yii::$app->request->post());

            // validate all models
            $valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelsGrnItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelGrn->save(false)) {
                        foreach ($modelsGrnItem as $modelGrnItem) {
                            $modelGrnItem->grn_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->item_id])->one();

                            if ($stock) {
                                $stockmodel = VeplStationariesStock::findOne($stock->id);
                                $stockmodel->balance_qty = $stock->balance_qty + $modelGrnItem->quantity;
                            } else {
                                $stockmodel = new VeplStationariesStock();
                                $stockmodel->item_id = $modelGrnItem->item_id;
                                $stockmodel->balance_qty = $modelGrnItem->quantity;
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
                    'modelsGrnItem' => (empty($modelsGrnItem)) ? [new VeplStationariesGrnItem] : $modelsGrnItem
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
        $modelGrn = VeplStationariesGrn::find()->where(['id' => $id])->one();

        $existingGrnId = VeplStationariesGrnItem::find()->select('id')->where(['grn_id' => $id])->asArray()->all();
        $existingGrnId = ArrayHelper::getColumn($existingGrnId, 'id');
        
       $existingGrnItem = VeplStationariesGrnItem::find()->select('quantity')->where(['grn_id' => $id])->asArray()->all();
       $existingGrnItem = ArrayHelper::getColumn($existingGrnItem, 'quantity');
       
       $existingGrnItemId = VeplStationariesGrnItem::find()->select('item_id')->where(['grn_id' => $id])->asArray()->all();
       $existingGrnItemId = ArrayHelper::getColumn($existingGrnItemId, 'item_id');
       
       
        $modelGrnItems = VeplStationariesGrnItem::findAll(['id' => $existingGrnId]);
        $modelGrnItems = (empty($modelGrnItems)) ? [new VeplStationariesGrnItem] : $modelGrnItems;
       
        $post = Yii::$app->request->post();
        if ($modelGrn->load($post)) {
            
           foreach($existingGrnItemId as $key => $value){                
                 $stockDel = VeplStationariesStock::find()->where(['item_id' =>$value])->one();
                 $stockDel->balance_qty = $stockDel->balance_qty - $existingGrnItem[$key];
                 $stockDel->save(false);
            }

            $modelGrn->grn_date = Yii::$app->formatter->asDate($modelGrn->grn_date, "yyyy-MM-dd");

            $modelGrnItems = Model::createMultiple(VeplStationariesGrnItem::classname(), $modelGrnItems);
            Model::loadMultiple($modelGrnItems, Yii::$app->request->post());
            $newGrnId = ArrayHelper::getColumn($modelGrnItems, 'id');
            //print_r($newGrnId);

            $delGrnIds = array_diff($existingGrnId, $newGrnId);
            if (!empty($delGrnIds))
                VeplStationariesGrnItem::deleteAll(['id' => $delGrnIds]);

            $valid = $modelGrn->validate();
            // $valid = Model::validateMultiple($modelGrnItems) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $modelGrn->id = $id;
                    if ($flag = $modelGrn->save(false)) {

                        foreach ($modelGrnItems as $modelGrnItem) {
                            $modelGrnItem->quantity;
                            $modelGrnItem->grn_id = $modelGrn->id;
                            if (!($flag = $modelGrnItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $stock = VeplStationariesStock::find()->where(['item_id' => $modelGrnItem->item_id])->one();

                            if ($stock) {
                                $stockmodel = VeplStationariesStock::findOne($stock->id);
                                $stockmodel->balance_qty = $stock->balance_qty + $modelGrnItem->quantity;
                            } else {
                                $stockmodel = new VeplStationariesStock();
                                $stockmodel->item_id = $modelGrnItem->item_id;
                                $stockmodel->balance_qty = $modelGrnItem->quantity;
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
                        'modelsGrnItem' => (empty($modelGrnItems)) ? [new VeplStationariesGrnItem] : $modelGrnItems,
            ]);
        }
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
