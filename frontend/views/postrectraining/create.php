<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */

$this->title = 'Create Porec Training';
$this->params['breadcrumbs'][] = ['label' => 'Porec Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="porec-training-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
