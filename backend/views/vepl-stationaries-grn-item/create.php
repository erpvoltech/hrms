<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrnItem */

$this->title = 'Create Vepl Stationaries Grn Item';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Grn Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-grn-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
