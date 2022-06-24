<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceEquipment */

$this->title = 'Update Policy: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurance Equipments', 'url' => ['equipmentindexnew']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-equipment-update">

    <?= $this->render('_equipmentupdateform', [
        'model' => $model,
    ]) ?>

</div>
