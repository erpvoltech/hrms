<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceEquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insurance-Equipments';
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
<div class="vg-insurance-equipment-index">
      
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create Insurance-Equipment', ['create'], ['class' => ' btn-sm btn-success']) ?>
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
            'heading' => '<h4 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Equipment Policy List </h4>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'icn_id',
            //'insurance_agent_id',
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
            'sum_insured',
            'premium_paid',
            [
                'attribute' => 'valid_from',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'valid_to',
                'format' => ['date', 'php:d-m-Y']
            ],
            
            //'property_type',
            //'property_name',
            //'property_no',
           /* ['attribute' =>'property_no',
             'format' => 'raw',
                'value' => function($model) {
                    $tooltip = $model->property_no;
                    if (strlen($tooltip) > 20)
                        $loctxt =  substr($tooltip, 0, 25) . '...';
                    else
                        $loctxt =  $tooltip;
                    
                    return '<a title="' . $tooltip . '">' . $loctxt . '</a>';
                },
            ],*/
            //'location',
            
            
            /*[
               'attribute' => 'icn_id',
               'value' => 'company.company_name',
            ],
            [
               'attribute' => 'insurance_agent_id',
               'value' => 'agent.agent_name',
            ],*/
            
            
            
            //,
            //'property_value',
            
            //'user_division',
            //'insured_to',
            //'equipment_service',
            //'remarks',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
