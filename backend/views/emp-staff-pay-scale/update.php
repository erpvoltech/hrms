<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmpStaffPayScale */

//$this->title = 'Update Emp Staff Pay Scale: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Staff Pay Scales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-staff-pay-scale-update">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Update Emp Staff Pay Scale</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
