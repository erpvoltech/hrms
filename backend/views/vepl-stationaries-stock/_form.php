<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use app\models\VeplStationaries;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$stationaryData = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesStock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Stationary/Printing Material</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                                $form->field($model, "item_id")->widget(Select2::classname(), [
                                    'data' => $stationaryData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '220px'
                                    ],
                                ]);
                                ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'balance_qty')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
