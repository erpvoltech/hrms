<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\EmpDetails;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgGpaEndorsementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'VG GPA Endorsements';
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
<div class="vg-gpa-endorsement-index">
  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php //echo Html::a('Create VG GPA Endorsement', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'toolbar' => [
          
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GPA Endorsement List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'gpa_mother_policy_id',
            [
               'attribute' => 'gpa_mother_policy_id',
               'value' => 'gpaPolicy.policy_no',
            ],
            'endorsement_no',
            'start_date',
            'end_date',
            //'endorsement_premium_paid',
            [
                'header' => 'Annexure',
                'format' => 'raw',
                'value' => function ($model) {
                        return Html::a('View', ['vg-gpa-endorsement/gpaendoannexure', 'id' => $model->endorsement_no]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
