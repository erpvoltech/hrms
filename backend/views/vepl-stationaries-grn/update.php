<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrn */

$this->title = 'Update Vepl Stationaries Grn: ' . $modelGrn->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Grns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelGrn->id, 'url' => ['view', 'id' => $modelGrn->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-grn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
        'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
