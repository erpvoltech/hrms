<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\College */

$this->title = 'Update College: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="college-update">

  <div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Update College</div>
    <div class="panel-body">
      <h1><?= Html::encode($this->title) ?></h1>



      <?=
      $this->render('_form', [
          'model' => $model,
      ])
      ?>

    </div>
  </div>
</div>
