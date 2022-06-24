<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\EmpDetails;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgGmcPolicySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'VG GMC Policies';
$this->params['breadcrumbs'][] = 'VG GMC Policies';
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
<div class="vg-gmc-policy-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create GMC Policy', ['create'], ['class' => ' btn-sm btn-success']) ?>
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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GMC List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'policy_name',
            /*[
               'attribute' => 'insurance_comp_id',
               'value' => 'company.company_name',
            ],
            [
               'attribute' => 'insurance_agents_id',
               'value' => 'agent.agent_name',
            ],*/

            //'insurance_comp_id',
            //'insurance_agents_id',
            'policy_no',
            'from_date',
            'to_date',
            'premium_paid',
            //'location',
            //'remarks',
            [
                'header' => 'Annexure',
                'format' => 'raw',
                'value' => function ($model) {
                        return Html::a('View', ['gmcannexure', 'id' => $model->policy_no]).' / '.Html::a('Export', ['exportgmcannexdata', 'id' => $model->policy_no]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
