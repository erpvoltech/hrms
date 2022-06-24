<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\models\CmdFamilyPolicy;

$query = CmdFamilyPolicy::find()
        ->groupBy(['name'])
        ->orderBy(['name' => SORT_ASC]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
        ]);
?>
<div class="row">
    <div class="pull-left" style="padding:30px 5px 5px 10px;">
<?= Html::a('Create', ['cmdcreate'], ['class' => ' btn-sm btn-success']) ?>
    </div>
</div>
<br><br><br>
<?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    //'policy_number',
    'name',
    /*'insured_company',
    ['attribute' => 'sum_insured',
                'contentOptions' => ['style' => 'text-align: right;'],
    ],
    ['attribute' => 'premium_amount',
                'contentOptions' => ['style' => 'text-align: right;'],
    ],
    'terms',
    [
        'attribute' => 'policy_date',
        'format' => ['date', 'php:d.m.Y']
    ],
    [
        'attribute' => 'maturity_date',
        'format' => ['date', 'php:d.m.Y']
    ],*/
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                                '<span><i class="fa fa-eye" style="font-size:14px; color:#337ab7;"></i>  </span>', ['vg-gmc-policy/cmdview', 'id' => $model->name], ['target' => '_blank', 'title' => 'View', 'data-pjax' => '0']
                );
            },
            /*'update' => function ($url, $model) {
                return Html::a(
                                '<span><i class="fa fa-pencil" style="font-size:14px; color:#337ab7;"></i>  </span>', ['vg-gmc-policy/cmdupdate', 'id' => $model->id], ['title' => 'Update', 'data-pjax' => '0']
                );
            },
            'delete' => function ($url, $model) {
                return Html::a(
                                '<span><i class="fa fa-trash-o" style="font-size:14px; color:#337ab7;"></i>  </span>', ['vg-gmc-policy/cmddelete', 'id' => $model->id], ['title' => 'Delete', 'data-pjax' => '0']
                );
            },*/
        ],
    ],
        /* ['class' => 'kartik\grid\ActionColumn', 'urlCreator' => function() {
          return '#';
          }] */
];



echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'panel' => [
        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Policy List </h5>',
        'type' => 'info',
    ],
	'toolbar'=>[false],

]);
