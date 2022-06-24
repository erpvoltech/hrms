<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecruitmentBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recruitment Batches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-batch-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recruitment Batch', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            #'date',
            #'batch_name',
			[
				'attribute' => 'date',
				'filterInputOptions' => [
					'class'       => 'form-control',
					'placeholder' => 'Search'
				 ]
			],
			[
				'attribute' => 'batch_name',
				'filterInputOptions' => [
					'class'       => 'form-control',
					'placeholder' => 'Search'
				 ]
			],

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
        ],
    ]); ?>
</div>
