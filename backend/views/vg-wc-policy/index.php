<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgWcPolicySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'VG WC Policies';
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
<div class="vg-wc-policy-index">
        
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create WC Policy', ['create'], ['class' => ' btn-sm btn-success']) ?>
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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> WC List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'policy_no',
            'employer_name_address:ntext',
			'project_address:ntext',
			'from_date',
			'to_date',
           // 'contractor_name_address:ntext',
            //'nature_of_work:ntext',
            //'policy_holder_address:ntext',
            
            'premium_paid',
            //'wc_coverage_days',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
