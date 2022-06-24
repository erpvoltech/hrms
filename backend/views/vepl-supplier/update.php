<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplSupplier */

$this->title = 'Update Supplier: ' . $model->supplier_name;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-supplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
