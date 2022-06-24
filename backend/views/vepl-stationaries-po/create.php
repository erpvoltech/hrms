<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPo */

$this->title = 'Create Vepl Stationaries Po';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-po-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
         'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
