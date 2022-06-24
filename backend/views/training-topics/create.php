<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingTopics */

$this->title = 'Create Training Topics';
$this->params['breadcrumbs'][] = ['label' => 'Training Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-topics-create">
<div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Create Training Topics</div>
    <div class="panel-body">
   
      <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
 