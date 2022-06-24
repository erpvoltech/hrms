<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPo */

$this->title = 'Update Vepl Stationaries Po: ' . $modelGrn->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelGrn->id, 'url' => ['view', 'id' => $modelGrn->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-po-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
        'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
