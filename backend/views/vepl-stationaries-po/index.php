<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;

error_reporting(0);

/* if (Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"])
  $unit = Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"];
  else
  $unit = NULL;

  if (Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"])
  $design = Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"];
  else
  $design = NULL;

  if (Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"])
  $dept = Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"];
  else
  $dept = NULL; */
?>

<style>
    .glyphicon {
        padding-right:10px;
    } table{
        background-color:#DFDFDF;
    }
</style>
<!--<php echo $this->render('_search', ['model' => $searchModel]); ?>-->
<div class="vepl-stationaries-po-index" >

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 20px;">
            <?= Html::a('Create PO', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'toolbar' => [
            '<button id="export" class="btn btn-default"  title=Export data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Export </button>'
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> PO List</h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'po_no',
            //'po_date',
            [
                'attribute' => 'po_date',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'last_purchase_date',
                'format' => ['date', 'php:d-m-Y']
            ],
            //'last_purchase_date',
            //'po_supplier_id',
            //'po_prepared_by',
            //'po_approved_by',
            ['attribute' => 'po_net_amount',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format'=>['decimal', 2, '.', '']],
            [
                'attribute' => 'po_approval_status',
                'value' => function($data) {
                    if ($data->po_approval_status == 0){
                        return 'Waiting for Approval';
                    }else{
                        return 'Approved';
                    }
                }
            ],
            ['label' => 'Download PO',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->po_approval_status == 0) {
                        return 'PO Yet to Approve';
                    } else {
                        return Html::a('Click Here', 'podownload?id=' . $model->id, ['target' => '_blank', 'data-pjax' => "0"]);
                    }
                },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}   {delete} ',
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>

</div>
