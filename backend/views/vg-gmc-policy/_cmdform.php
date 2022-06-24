<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
?>

<div class="vepl-stationaries-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">CMD Family Policy</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'name')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'policy_number')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'insured_company')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'sum_insured')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'premium_amount')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'terms')->dropDownList(['Quarterly' => 'Quarterly', 'Yearly' => 'Yearly', 'Single' => 'Single'], ['prompt' => 'Select Terms']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'policy_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete'=>'off', 'readOnly'=>true],
                        'clientOptions' => [
						'dateFormat' => 'dd-MM-yyyy',
                            'yearRange' => '2005:2050',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'maturity_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete'=>'off', 'readOnly'=>true],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'yearRange' => '2005:2050',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="row">
				<div class="col-sm-4">
                    <?=
                    $form->field($model, 'policy_paid_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete'=>'off', 'readOnly'=>true],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'yearRange' => '2005:2050',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'remarks')->textInput() ?>
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
