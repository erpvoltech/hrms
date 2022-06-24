<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrnItem */

$this->title = 'Update Vepl Stationaries Grn Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Grn Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-grn-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
