<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-index">
  <div class="panel panel-default">
    <div class="panel-heading text-center"> Colleges</div>
    <div class="panel-body">
      <h1><?= Html::encode($this->title) ?></h1>

      <p>
        <?= Html::a('Create College', ['create'], ['class' => 'btn-sm btn-success']) ?>
      </p>

      <br> <?=
      GridView::widget([
          'dataProvider' => $dataProvider,
		  'options' => ['style' => 'width:65%'],
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],             
              'collegename',
			  ['label' => 'View',
                        'format' => 'raw',
                        'value' => function ($model) {                           
                            return Html::a('Emp. List',Yii::$app->homeUrl.'emp-details/college-index?id='.$model->id,
							['target' => '_blank',  'data-pjax'=>"0"]);
                        },
            ],
              ['class' => 'yii\grid\ActionColumn'],
          ],
      ]);
      ?>
    </div>
  </div></div>
