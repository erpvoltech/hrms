<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceVehicle */

$this->title = 'Update Insurance-Vehicle: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-vehicle-update">

    <?= $this->render('_vehicleupdateform', [
        'model' => $model,
    ]) ?>

</div>
