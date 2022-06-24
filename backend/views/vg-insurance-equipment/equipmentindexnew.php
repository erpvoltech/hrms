<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\VgInsuranceEquipment;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\base\Model;
error_reporting(0);

?>
<style>
    .b{
        color:#fff;
        visibility: hidden
    }
    .text{
        color: #009933 ;
        font-weight:bold;
        font-size:16px;

    }
    .addrline {
        border-bottom: 1px solid;
        color: #942509;
        font-weight: normal;
        font-size: 14px;
        margin-bottom: 1em;
        padding-bottom: 2px;
    }

</style>
<div class="vg-insurance-agents-view">
        <div class="row">
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create Policy-Equipment', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
        </div><br>
    <?php
    $query = new Query;
    /*$query = EmpDetails::find()->joinWith(['employeeStatutoryDetail'])
            ->where(['emp_details.status' => 'Active'])
             ->andWhere(['IN', 'emp_statutorydetails.gpa_no', ['']])
             ->orWhere(['IS', 'emp_statutorydetails.gpa_no', NULL]);*/
    #$searchModel = new Bill();
$query = VgInsuranceEquipment::find();
$query->select('insurance_no,insured_to,equipment_service,
                 sum(sum_insured) as sum_total,
                      location,sum(premium_paid) as premium_total');


// The problem is in the below sum

$query->groupBy('insurance_no')
->orderBy(['insurance_no'=>SORT_DESC]);
//$query->sum('teis_bill_override_cbm'); already calculated
#$query->all();



    /*$query = VgInsuranceEquipment::find()
            ->select('sum(sum_insured) as my_sum)
            ->groupBy(['insurance_no'])
             ->orderBy(['insurance_no'=>SORT_DESC]);*/

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
            /*   'pagination' => [
              'pageSize' => 5,
              ], */
    ]);
    ?>

   <?= GridView::widget([
       'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'toolbar' => [

        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Equipment Insured List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'insurance_no',
            'insured_to',
            'equipment_service',
            ['attribute' =>'location',
             'format' => 'raw',
                'value' => function($model) {
                    $tooltip = $model->location;
                    if (strlen($tooltip) > 20)
                        $loctxt =  substr($tooltip, 0, 30) . '...';
                    else
                        $loctxt =  $tooltip;

                    return '<a title="' . $tooltip . '">' . $loctxt . '</a>';
                },
            ],
            ['attribute' => 'sum_total',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format'=>['decimal', 2, '.', '']
            ],
            ['attribute' => 'premium_total',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format'=>['decimal', 2, '.', '']
            ],

            /*[
                'attribute' => 'valid_from',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'valid_to',
                'format' => ['date', 'php:d-m-Y']
            ],*/


		[
                       'class' => 'yii\grid\ActionColumn',
                       'template' => '{view}',
                   'buttons' => [
                     'view' => function ($model,$key) {

                     return Html::a(
                     '<span class="glyphicon glyphicon-list-alt"></span>',
                     ['view','id' => $key->insurance_no],['data-pjax' => 0]
		     );                   
                     }
                     ]
                   ],


        /*   ['class' => 'yii\grid\ActionColumn',
               'template' => '{view}',
               'buttons' => [
                   'view' => function ($url, $model) {
                      return Html::a('<span><i class="fa fa-eye" style="color:#337ab7;"></i>  </span>', ['view', 'id' => $model->insurance_no], ['data-pjax' => '0']);
                   }
                       ],
                ],*/
        ],
    ]); ?>
</div>


