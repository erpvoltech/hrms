<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceBuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insurance Buildings';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .glyphicon {
        padding-right:10px;
    } table{
        background-color:#DFDFDF;
    }

    /*.panel {
        margin-right: 180px;   
        }*/
</style>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="vg-insurance-building-index">

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
<?php echo Html::a('Create Insurance-Building', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>

  <?= GridView::widget([
       'dataProvider' => $dataProvider,     
        //'filterModel' => $searchModel,
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h4 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Building Policy List </h4>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'icn_id',
            //'insurance_agent_id',
            /* [
              'attribute' => 'icn_id',
              'value' => 'company.company_name',
              ],
              [
              'attribute' => 'insurance_agent_id',
              'value' => 'agent.agent_name',
              ], */
            'insurance_no',
            //'property_type',
            'property_name',
            //'location',
            ['attribute' => 'location',
                'format' => 'raw',
                'value' => function($model) {
                    $tooltip = $model->location;
                    if (strlen($tooltip) > 20)
                        $loctxt = substr($tooltip, 0, 30) . '...';
                    else
                        $loctxt = $tooltip;

                    return '<a title="' . $tooltip . '">' . $loctxt . '</a>';
                },
            ],
            ['attribute' => 'sum_insured',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            ['attribute' => 'premium_paid',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            //'property_no',
            //'property_value',
            'valid_from',
            'valid_to',
            'insured_to',
            //'remarks',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]);
    ?>
   
</div>
