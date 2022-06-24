<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationaries */

//$this->title = 'Update Vepl Stationaries: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Policy', 'url' => ['cmdindex']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['cmdview', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_cmdform', [
        'model' => $model,
    ]) ?>

</div>