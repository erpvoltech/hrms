<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectEmpAttendance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-emp-attendance-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>
	
    <?php //$form->field($model, 'month')->textInput() ?>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'days')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'hours')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day1_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day1_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day2_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day2_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day3_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day3_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day4_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day4_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day5_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day5_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day6_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day6_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day7_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day7_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day8_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day8_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day9_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day9_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day10_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day10_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day11_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day11_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day12_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day12_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day13_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day13_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day14_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day14_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day15_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day15_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day16_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day16_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day17_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day17_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day18_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day18_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day19_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day19_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day20_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day20_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day21_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day21_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day22_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day22_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day23_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day23_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day24_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day24_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day25_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day25_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day26_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day26_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day27_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day27_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day28_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day28_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day29_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day29_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day30_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day30_out')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-md-4">
    <?= $form->field($model, 'day31_in')->textInput(['maxlength' => true]) ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'day31_out')->textInput(['maxlength' => true]) ?>
	</div></div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
