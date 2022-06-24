<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Benefits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-benefits-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--Html::a('Create Emp Benefits', ['create'], ['class' => 'btn btn-success']) -->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'wl',
            'grade',
			[
				'attribute' => 'travelmode_ss',
				'headerOptions' => ['style' => 'width:20%'],
			],
			[
				'attribute' => 'travelmode_ts',
				'headerOptions' => ['style' => 'width:20%'],
			],           
            'lodging_metro',
            'lodging_nonmetro',
            'boarding_metro',
            'boarding_nonmetro',
            'gpa',
            'gmc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
