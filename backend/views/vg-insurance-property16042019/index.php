<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;

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
<div class="vg-insurance-property-index">

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create Vg Insurance Property', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>
    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'toolbar' => [
          
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Property Information System List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'mother_id',
            'property_type',
            'insurance_no',
            'property_name',
            'property_no',
            'property_value',
            'sum_insured',
            //'premium_paid',
            [
                'attribute' => 'valid_from',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'valid_to',
                'format' => ['date', 'php:d-m-Y']
            ],
            'location',
            'insured_to',
            [
               'attribute' => 'icn_id',
               'value' => 'company.company_name',
            ],
            [
               'attribute' => 'insurance_agent_id',
               'value' => 'agent.agent_name',
            ],
            //'user',
            //'user_division',
            //'equipment_service',
            //'icn_id',
            //'insurance_agent_id',
            //'remarks',

            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}',
                    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
