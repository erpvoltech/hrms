<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-index">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Designations</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Designation', ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          
            'designation',
			'salary_slot',
           
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template' => '&nbsp;&nbsp;&nbsp;{update} &nbsp;&nbsp;&nbsp; {delete}',
			],
        ],
    ]); ?>
</div>
</div></div>
