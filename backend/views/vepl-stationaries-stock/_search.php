<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VeplStationaries;

$issuedQty = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesStockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>

    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'item_id')?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'balance_qty') ?></div>
    </div>
    

    <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
