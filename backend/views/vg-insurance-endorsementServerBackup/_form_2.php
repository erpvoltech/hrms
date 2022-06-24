<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\VgInsuranceMotherPolicy;

$motherpolicyno = VgInsuranceMotherPolicy::findone($_GET['id']);
$model->mother_policy_id = $motherpolicyno->policy_no;
?>

<div class="vg-insurance-endorsement-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Endorsement Policy Form </i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($model, 'mother_policy_id')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-sm-5">
                     <?= $form->field($model, 'endorsement_no')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?=
                    $form->field($model, 'start_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-5">
                     <?=
                    $form->field($model, 'end_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($model, 'endorsement_premium_paid')->textInput() ?>
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
