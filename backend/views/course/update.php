<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = 'Update Course: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">

  <div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Update Course</div>
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
