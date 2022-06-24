<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\VeplStationariesIssueSub;
use app\models\VeplStationaries;
use yii\helpers\ArrayHelper;

$issuedQty = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-issue-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'layout' => 'horizontal',
    ]);
    ?>

    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'issue_date') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'issued_to') ?></div>
    </div>


    <div class="row">
        <!--<div class=" col-lg-4"><= $form->field($model, 'stationaries_id')->dropDownList($issuedQty, ['prompt' => 'Select...']) ?> </div>-->
        <div class=" col-lg-4"><?= $form->field($model, 'remarks') ?></div>
    </div>
    <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>	  
    <?php ActiveForm::end(); ?>
</div>
