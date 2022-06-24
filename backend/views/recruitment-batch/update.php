<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecruitmentBatch */

$this->title = 'Update Recruitment Batch: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recruitment Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recruitment-batch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
