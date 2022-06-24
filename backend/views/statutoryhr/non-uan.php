<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\EmpStatutorydetails;
use common\models\EmpDetails;
use kartik\export\ExportMenu;

//echo Yii::$app->getRequest()->getQueryParam('month');
$this->title = 'Non UAN List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pf-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


      <?php 
   $gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
       'empcode',
       'empname',
          [
          'attribute' => 'unit_id',
      'format' => 'raw',
           'value' => function ($model) {                   
            return $model->units['name'];
            },
           ],  
       'employeeStatutoryDetail.epfuanno',
       'status',
]; 

$gridColumnsdisplay = [
     'empcode',
       'empname',
          [
          'attribute' => 'unit_id',
      'format' => 'raw',
           'value' => function ($model) {                   
            return $model->units['name'];
            },
           ],  
       'employeeStatutoryDetail.epfuanno',
       'status',
]; 
 ?>

  <?= GridView::widget([
       'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       'toolbar' =>  [        
       ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'options' => ['id'=>'expMenu1'], // optional to set but must be unique
    'target' => ExportMenu::TARGET_BLANK
  ]), 
    ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Non UAN List</h3>',
       ],
       'columns' => $gridColumnsdisplay,
           ]);
           ?>

            <!--<?/*= GridView::widget([

        'dataProvider' => $dataProvider,
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],         
            'empcode',
             'empname',
       
         [
          'attribute' => 'unit_id',
      'format' => 'raw',
           'value' => function ($model) {                   
            return $model->units['name'];
            },
           ],  
       'employeeStatutoryDetail.epfuanno',
       'status',
        ],

    ]);*/ ?>-->

    
    
</div>