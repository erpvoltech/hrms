<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */

$this->params['breadcrumbs'][] = ['label' => 'Porec Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="porec-training-update">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Update Post Recruitment Training</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>