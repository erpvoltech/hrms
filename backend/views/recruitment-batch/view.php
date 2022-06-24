<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecruitmentBatch */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recruitment Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-batch-view">

    <h1> <?php /*<?= Html::encode($this->title) ?>*/ ?></h1>

    <p>
        <?php /*<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'batch_name',
        ],
    ]) ?>

</div>
