<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceCompany */

//$this->title = 'Update ISP: ' . $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
