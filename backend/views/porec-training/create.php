<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */

$this->params['breadcrumbs'][] = ['label' => 'Porec Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="porec-training-create">
<div class="panel panel-default">
   <div class="panel-heading text-center">Create Post Recruitment training </div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>