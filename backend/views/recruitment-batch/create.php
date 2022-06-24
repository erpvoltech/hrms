<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecruitmentBatch */

$this->title = 'Create Recruitment Batch';
$this->params['breadcrumbs'][] = ['label' => 'Recruitment Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-batch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
