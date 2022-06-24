<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceVehicle */

$this->title = 'Create Insurance-Vehicle';
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-vehicle-create">
   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
