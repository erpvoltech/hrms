<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceBuilding */

$this->title = 'Update Insurance-Building: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-building-update">

    <?= $this->render('_buildingupdateform', [
        'model' => $model,
    ]) ?>

</div>
