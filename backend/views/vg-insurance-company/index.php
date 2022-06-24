<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = 'Insurance Service Provider';
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
<?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="vg-insurance-company-index">

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create ISP', ['create'], ['class' => ' btn-sm btn-success']) ?>
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
            'company_name',

            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}',
                    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
