<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Designation */

$this->title = 'Update Designation';
$this->params['breadcrumbs'][] = ['label' => 'Designations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="designation-update">
<div class="panel panel-default">
   <div class="panel-heading text-center" style="font-size:18px;">Update Designation</div>
  <div class="panel-body">
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
