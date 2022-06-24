<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salary Months';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-month-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Salary Month', ['set-month'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],           
            'month',            
			['class' => 'yii\grid\ActionColumn',
				 'template' => '{month-delete}',
				   'buttons' => [					
					 'month-delete' => function ($url,$model) {
						return Html::a(
							'<span class="glyphicon glyphicon-trash
							"></span>', 
							$url);
						},
					],
				],
        ],
    ]); ?>
</div>