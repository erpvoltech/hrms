<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpStaffPayScaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Emp Staff Pay Scales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-staff-pay-scale-index">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Employee Staff Pay Scales</div>
  <div class="panel-body">
   <h1><?= Html::encode($this->title) ?></h1>
   <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   <p>
      <?= Html::a('Create Emp Staff Pay Scale', ['create'], ['class' => 'btn-sm btn-success']) ?>
   </p>
   <br>
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Employee Details</h3>',
       ],
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'salarystructure',
           'basic',
           'dearness_allowance',
           'hra',
          // 'spl_allowance',
           'conveyance_allowance',
           'lta',
           'medical',
          // 'pli',
           'other_allowance',
           ['class' => 'yii\grid\ActionColumn'],
       ],
   ]);
   ?>
</div>
</div></div>
