<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrn */

$this->title = 'Create Vepl Stationaries Grn';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Grns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-grn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
         'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
