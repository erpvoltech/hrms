<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */
/* @var $form yii\widgets\ActiveForm */

use app\models\TrainingTopics;
use app\models\RecruitmentBatch;
use yii\helpers\ArrayHelper;

$topicsData=ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$batchData=ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');


?>

<div class="porec-training-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'trainig_topic_id')->dropDownList($topicsData,
        ['prompt'=>'Select...']) ?>

    <?= $form->field($model, 'batch_id')->dropDownList($batchData,
        ['prompt'=>'Select...']) ?>
		
	<div class="form-group">
        <?= Html::submitButton('Go', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
