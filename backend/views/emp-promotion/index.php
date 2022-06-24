<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpPromotionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Promotions';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="emp-promotion-index">
  <div class="emp-promotion-search">
  <div class="panel panel-default">
      <div class="panel-heading text-center">Promotions</div>
      <br>
   <h1><?= Html::encode($this->title) ?></h1>
   <?php echo $this->render('_search', ['model' => $searchModel]); ?>
   <br>
   <p style="padding-left:15px;">
      <?= Html::a('Create Promotion', ['promotion'], ['class' => 'btn-sm btn-primary']) ?>
	  <?= Html::a('Promotion Import', ['import-promotion'], ['class' => 'btn-sm btn-primary']) ?>
  </p>
  <br>
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       //  'filterModel' => $searchModel,
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'employee.empcode',
           'employee.empname',          
           'effectdate',
           'ss_to',
           'wl_to',
           'grade_to',
           'gross_to',
		   'pli_to',
           ['class' => 'yii\grid\ActionColumn'],
       ],
   ]);
   ?>
</div>
  </div>
</div>
