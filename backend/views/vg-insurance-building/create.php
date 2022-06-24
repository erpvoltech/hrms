<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceBuilding */

$this->title = 'Create Insurance-Building';
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-building-create">

   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
