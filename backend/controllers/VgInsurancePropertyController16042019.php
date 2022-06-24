<?php

namespace backend\controllers;

use Yii;
use app\models\VgInsuranceProperty;
use app\models\VgInsurancePropertySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImportExcel;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Model;

/**
 * VgInsurancePropertyController implements the CRUD actions for VgInsuranceProperty model.
 */
class VgInsurancePropertyController extends Controller {

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
     * Lists all VgInsuranceProperty models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VgInsurancePropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VgInsuranceProperty model.
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
     * Creates a new VgInsuranceProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new VgInsuranceProperty();

        if ($model->load(Yii::$app->request->post())) {
            $model->valid_from = Yii::$app->formatter->asDate($model->valid_from, "yyyy-MM-dd");
            $model->valid_to = Yii::$app->formatter->asDate($model->valid_to, "yyyy-MM-dd");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionExportproperty() {
        return $this->render('exportproperty');
    }
    
    public function actionExportpidata() {
        return $this->render('exportpidata');
    }
    
    public function actionPropertyinsuranceremainder(){
        $propertyRemainder = VgInsuranceProperty::find()->where('valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')->all();
        return $this->render('propertyinsuranceremainder', ['propertyRemainder' => $propertyRemainder,]);
    }
    
    public function actionPropertyinsuranceexpiry(){
        $propertyExpiry = VgInsuranceProperty::find()->where('valid_to < DATE(NOW())')->all();
        return $this->render('propertyinsuranceexpiry', ['propertyExpiry' => $propertyExpiry,]);
    }
    
    public function actionImportproperty() {
        $model = new importExcel();
        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $model->file->saveAs('pis/' . $model->file->baseName . '.' . $model->file->extension);
                $fileName = 'pis/' . $model->file->baseName . '.' . $model->file->extension;
            }
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $fileName,
                        'setFirstRecordAsKeys' => true,
            ]);

            $countrow = 0;
            $startrow = 1;
            $totalrow = count($data);
            #echo '<pre>';
            #print_r($data);
            #echo '</pre>';
            // \Yii::$app->response->data = $data; 
            if ($model->uploadtype == 1 && $model->uploaddata == 1) {
                $transaction = $connection->beginTransaction();
                try {
                    $i=1;
                   
                    foreach ($data as $key => $excelrow) {                         
                        if (!empty($excelrow['Property Type'])) {
                            $modelProperty = new VgInsuranceProperty();
                            $modelProperty->property_type = $excelrow['Property Type'];
                            $modelProperty->insurance_no = $excelrow['Insurance No'];
                            $modelProperty->property_name = $excelrow['Property Name'];
                            $modelProperty->property_no = $excelrow['Property No'];
                            $modelProperty->property_value = $excelrow['Property Value'];
                            $modelProperty->sum_insured = $excelrow['Sum Insured'];
                            $modelProperty->premium_paid = $excelrow['Premium Paid'];
                            $modelProperty->valid_from = Yii::$app->formatter->asDate($excelrow['Valid From'], "yyyy-MM-dd");
                            $modelProperty->valid_to = Yii::$app->formatter->asDate($excelrow['Valid To'], "yyyy-MM-dd");
                            $modelProperty->location = $excelrow['Location'];
                            $modelProperty->user = $excelrow['User'];
                            $modelProperty->user_division = $excelrow['User Division'];
                            $modelProperty->insured_to = $excelrow['Insured To'];
                            $modelProperty->equipment_service = $excelrow['Equipment Service'];
                            $modelProperty->icn_id = $excelrow['Insurance Company Name'];
                            $modelProperty->insurance_agent_id = $excelrow['Agent Name'];
                            $modelProperty->remarks = $excelrow['Remarks'];
                            $modelProperty->save(false);
                            $startrow++;
                        }
                        $i++;
                    }
                    if ($countrow == 0) {
                        $transaction->commit();
                        $insertrows = $startrow - 1;
                        Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else if ($model->uploadtype == 2 && $model->uploaddata == 1) {
                $transaction = $connection->beginTransaction();
                try {
                    foreach ($data as $key => $excelrow) {
                        if (!empty($excelrow['Insurance No'])) {
                            $propertyUpdate = VgInsuranceProperty::find()->where(['insurance_no' => $excelrow['Insurance No']])->one();
                            if ($propertyUpdate) {
                                $modelProperty = VgInsuranceProperty::findOne($propertyUpdate->id);
                                $modelProperty->property_type = $excelrow['Property Type'];
                                $modelProperty->insurance_no = $excelrow['Insurance No'];
                                $modelProperty->property_name = $excelrow['Property Name'];
                                $modelProperty->property_no = $excelrow['Property No'];
                                $modelProperty->property_value = $excelrow['Property Value'];
                                $modelProperty->sum_insured = $excelrow['Sum Insured'];
                                $modelProperty->premium_paid = $excelrow['Premium Paid'];
                                $modelProperty->valid_from = Yii::$app->formatter->asDate($excelrow['Valid From'], "yyyy-MM-dd");
                                $modelProperty->valid_to = Yii::$app->formatter->asDate($excelrow['Valid To'], "yyyy-MM-dd");
                                $modelProperty->location = $excelrow['Location'];
                                $modelProperty->user = $excelrow['User'];
                                $modelProperty->user_division = $excelrow['User Division'];
                                $modelProperty->insured_to = $excelrow['Insured To'];
                                $modelProperty->equipment_service = $excelrow['Equipment Service'];
                                $modelProperty->icn_id = $excelrow['Insurance Company Name'];
                                $modelProperty->insurance_agent_id = $excelrow['Agent Name'];
                                $modelProperty->remarks = $excelrow['Remarks'];
                                $modelProperty->save(false);
                            } else {
                                Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: This is not updated Record');
                                $startrow++;
                                $countrow += 1;
                                continue;
                            }
                            $startrow++;
                        }
                    }
                    if ($countrow == 0) {
                        $transaction->commit();
                        $insertrows = $startrow - 1;
                        Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
            unlink($fileName);
            return $this->redirect('index');
        }

        return $this->render('importproperty', [
                    'model' => $model,
        ]);
    }

    public function actionViewproperty($id) {
        $searchModel = new VgInsurancePropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $propertyPolicy = VgInsuranceProperty::find()->where(['mother_id' => $id])->all();

        return $this->render('viewproperty', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $propertyPolicy,
        ]);
    }

    /**
     * Updates an existing VgInsuranceProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->valid_from = Yii::$app->formatter->asDate($model->valid_from, "yyyy-MM-dd");
            $model->valid_to = Yii::$app->formatter->asDate($model->valid_to, "yyyy-MM-dd");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VgInsuranceProperty model.
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
     * Finds the VgInsuranceProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VgInsuranceProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VgInsuranceProperty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
