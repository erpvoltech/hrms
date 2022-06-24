<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrainingTopicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-topics-index">
<div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Training Topics</div>
    <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Training Topics', ['create'], ['class' => 'btn-sm btn-success'] ,['style' => ' float : left']) ?>
		<!--<?= Html::a('Import', ['import'], ['class' => 'btn btn-success'],['style' => ' float : right']) ?>-->
    </p>
    <br>
	

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            #'id',
            'topic_name',
            'created_by',
            'created_date',
            #'updated_by',
            //'updated_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
