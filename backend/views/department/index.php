<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
</style>
<div class="department-index">

<div class="panel panel-default">
   <div class="panel-heading text-center"> Departments</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Department', ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
          'options' => ['style' => 'width:65%'],
        'layout' => '{items}<div class="pagersummary"><div align="left">{summary} </div><div align="right" style="margin-top: -45px;">{pager}</div></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                 'contentOptions' => ['style' => 'width:50px'],
                ],
                   
             [
                'attribute'=>'name',
                'contentOptions' => ['style' => 'width:500px'],
             ],

            ['class' => 'yii\grid\ActionColumn',
                   'header'=>"Actions"],
        ],
    ]); ?>
</div>
</div></div>
