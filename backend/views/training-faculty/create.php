<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrainingFaculty */

$this->title = 'Create Training Faculty';
$this->params['breadcrumbs'][] = ['label' => 'Training Faculties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-faculty-create">
<div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Create Training Faculty </div>
    <div class="panel-body">
      

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
