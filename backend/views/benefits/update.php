<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmpBenefits */

$this->title = 'Update Emp Benefits: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Benefits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-benefits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
