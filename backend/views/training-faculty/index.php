<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrainingFacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-faculty-index">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Training Faculties</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Training Faculty', ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'faculty_ecode',
            'faculty_name',
            'created_by',
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        
    ]); ?>
</div>
</div>
</div>
