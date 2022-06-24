<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */

$this->params['breadcrumbs'][] = ['label' => 'Porec Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="porec-training-create">
<div class="panel panel-default">
   <div class="panel-heading text-center">Training Batch Status </div>
	<div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formselection', [
        'model' => $model,
    ]) ?>
</div>
</div>
</div>