<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceAgentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insurance Agents';
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
<div class="vg-insurance-agents-index">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create ISP/Agents', ['create'], ['class' => ' btn-sm btn-success']) ?>
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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Insurance Service Provider(ISP) List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'company_id',
            [
               'attribute' => 'company_id',
               'value' => 'companyName.company_name',
            ],
            'agent_name',
            'official_contact_no',
            'personal_contact_no',
            //'email_address:email',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
