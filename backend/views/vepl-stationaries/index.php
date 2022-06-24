<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;

error_reporting(0);

?>
<style>
.panel {
    margin-right: 180px;   
    }
</style>
<!--<php echo $this->render('_search', ['model' => $searchModel]); ?>-->
<div class="vepl-stationaries-index" >

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?= Html::a('Create Stationary', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'toolbar' => [
          
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Stationaries List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'item_category',
            'item_name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}   {delete} ',
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>

</div>
