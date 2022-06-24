<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingTopics */

$this->title = 'Update Training Topics: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Training Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="training-topics-update">

<div class="panel panel-default">
   <div class="panel-heading text-center" style="font-size:18px;">Update Training Topics</div>
  <div class="panel-body">
 
    <br>
    <?= $this->render('_form', [
        'model' => $model,
       'layout' => 'horizontal',
    ]) ?>

</div>
</div>
</div>