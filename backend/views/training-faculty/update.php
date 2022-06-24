<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\TrainingFaculty */


$this->params['breadcrumbs'][] = ['label' => 'Training Faculties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="training-faculty-update">
<div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Update Training Faculty</div>
    <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'layout' => 'horizontal',
    ]) ?>

</div>
</div>
</div>
