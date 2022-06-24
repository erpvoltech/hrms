<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\models\CmdFamilyPolicy;

$name = $_GET['id'];
$query = CmdFamilyPolicy::find()->where(['name' => $name]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
        ]);
?>

<br><br><br>
<?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'header' => 'Policy Number',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a($model->policy_number, ['vg-gmc-policy/cmdupdate', 'id' => $model->id], ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold', 'title' => 'Update Policy']);
        },
    ],
    'name',
    'insured_company',
    ['attribute' => 'sum_insured',
                'contentOptions' => ['style' => 'text-align: right;'],
    ],
    ['attribute' => 'premium_amount',
                'contentOptions' => ['style' => 'text-align: right;'],
    ],
    [
        'attribute' => 'policy_date',
        'format' => ['date', 'php:d.m.Y']
    ],
    [
        'attribute' => 'maturity_date',
        'format' => ['date', 'php:d.m.Y']
    ],
	[
        'attribute' => 'policy_paid_date',
        'format' => ['date', 'php:d.m.Y']
    ],
    ['label' => 'Due Date',
        'value' => function ($model) {
            if ($model->terms == 'Yearly') {
                /*$month = date('m-Y', strtotime($model->policy_date));
                $policyDt = date('d', strtotime($model->policy_date));
                $currentMonth = date('m-Y');
                $asonmonth = date('m', strtotime($model->policy_date));
                $year = date('Y');
                $y = $year + 1;
                if ($currentMonth < $month) {
                    return $policyDt . '.' . $currentMonth;
                } else if ($currentMonth > $month) {
                    return $policyDt . '.' . $asonmonth . '.' . $y;
                }*/
                $policyMonth = date('m', strtotime($model->policy_date));
                $policy_date = date('d', strtotime($model->policy_date));
                $currentYr = date('Y');
				$currentMon = date('m');
                $currentDa = date('Y-m-d');
                $currunt_policy_date = date('Y-m-d', strtotime($currentYr . '-' . $policyMonth . '-' . $policy_date));
                if($policyMonth > $currentMon){
                    $due_date1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($currunt_policy_date))));
                }else if($policyMonth == $currentMon){
                    $due_date1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($currunt_policy_date))));
                }else{
                    $due_date1 = date("Y-m-d", strtotime("+12 month", strtotime(date("Y-m-d", strtotime($currunt_policy_date)))));
                }
				$md = date('Y-m-d', strtotime($model->maturity_date));

                if ($currentDa <= date('Y-m-d', strtotime($due_date1)) && $md > $currentDa) {
                    return date('d.m.Y', strtotime($due_date1));
                }else{
                    return 'Matured';
                }
            } else if ($model->terms == 'Quarterly') {
                $policyMonth = date('m', strtotime($model->policy_paid_date));
                $policy_date = date('d', strtotime($model->policy_paid_date));
                $currentYr = date('Y');
                $currentDa = date('Y-m-d');
                $currunt_policy_date = date('Y-m-d', strtotime($currentYr . '-' . $policyMonth . '-' . $policy_date));
                //$due_date1 = date("Y-m-d", strtotime("+3 month", strtotime(date("Y-m-d", strtotime($currunt_policy_date)))));
                //$due_date2 = date("Y-m-d", strtotime("+6 month", strtotime(date("Y-m-d", strtotime($currunt_policy_date)))));
                $due_date3 = date("Y-m-d", strtotime("+3 month", strtotime(date("Y-m-d", strtotime($currunt_policy_date)))));

                /*if ($currentDa <= date('Y-m-d', strtotime($due_date1))) {
                    return date('d.m.Y', strtotime($due_date1));
                } else if ($currentDa <= date('Y-m-d', strtotime($due_date2))) {
                    return date('d.m.Y', strtotime($due_date2));
                } else {*/
                    return date('d.m.Y', strtotime($due_date3));
                //}
            } else if ($model->terms == 'Single') {
                return 'Single';
            }
        },
    ],
    'terms',
    'remarks',
        /* [
          'class' => 'yii\grid\ActionColumn',
          'template' => '{view}',
          'buttons' => [
          'view' => function ($url, $model) {
          return Html::a(
          '<span><i class="fa fa-eye" style="font-size:14px; color:#337ab7;"></i>  </span>', ['vg-gmc-policy/cmdview', 'id' => $model->name], ['title' => 'View', 'data-pjax' => '0']
          );
          },
          ],
          ], */
];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'panel' => [
        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Policy List </h5>',
        'type' => 'info',
    ],
    'toolbar' => [
        '{toggleData}',
        ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showConfirmAlert' => false,
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_CSV => false,
            //ExportMenu::FORMAT_PDF => false,
            ],
            'dropdownOptions' => [
                'label' => 'Export All',
                'class' => 'btn btn-secondary'
            ]
        ]),
    ],
]);



