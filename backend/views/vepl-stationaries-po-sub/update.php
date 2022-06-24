<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPoSub */

$this->title = 'Update Vepl Stationaries Po Sub: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Po Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-po-sub-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
