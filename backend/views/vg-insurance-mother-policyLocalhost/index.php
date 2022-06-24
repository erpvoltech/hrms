<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceMotherPolicySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Insurance Mother Policies';
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
<div class="vg-insurance-mother-policy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Insurance Mother Policy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
            [
               'attribute' => 'policy_for_id',
               'value' => 'policy.policy_type',
            ],
            [
               'attribute' => 'insurance_comp_id',
               'value' => 'company.company_name',
            ],
            [
               'attribute' => 'insurance_agents_id',
               'value' => 'agent.agent_name',
            ],
            //'policy_for_id',
            //'insurance_comp_id',
            //'insurance_agents_id',
            'policy_no',
            //'from_date',
            //'to_date',
            //'premium_paid',
            //'remarks',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
