<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsurancePolicy */

$this->title = 'Update Vg Insurance Policy: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-policy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
