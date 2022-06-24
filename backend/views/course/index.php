<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <div class="panel panel-default">
   <div class="panel-heading text-center"> Courses</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>

    <br> <?= GridView::widget([
        'dataProvider' => $dataProvider,
		
		'options' => ['style' => 'width:65%'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],           
            'coursename',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    </div>
</div>
