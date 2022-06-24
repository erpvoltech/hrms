<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesGrn */

$this->title = 'Create Vepl Stationaries GRN';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries GRNs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-grn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
