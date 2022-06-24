<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use app\models\TrainingTopics;
#use app\models\RecruitmentBatch;
use app\models\TrainingBatch;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTrainingSearch */
/* @var $form yii\widgets\ActiveForm */

$topicsData			=	ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$trainingBatchData	=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
?>

<style>
.form-control{ width: auto;
border-radius:0px;
}
</style>

<div class="porec-training-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
		'layout' => 'horizontal'
    ]); ?>
	<div class="row">
	
	<div class="form-group col-lg-3" style="margin-left:1px;">
	<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
        ['prompt'=>'Select...']) ?>
	</div>
		<div class="form-group col-lg-5">
	<?= $form->field($model, 'trainig_topic_id')->dropDownList($topicsData,
        ['prompt'=>'Select...']) ?>
		</div>
		 <div class="col-lg-2 form-group">
        <?= Html::submitButton('Search', ['class' => 'btn-sm btn-primary']) ?>
		</div>
		    <div class="col-lg-2 form-group">
        <?= Html::resetButton('Reset', ['class' => 'btn-sm btn-warning']) ?>
    </div>
</div>

    <?php //$form->field($model, 'id') ?>

    <?php //$form->field($model, 'training_type') ?>

    <?php //$form->field($model, 'name') ?>

    <?php //$form->field($model, 'division') ?>

    <?php //$form->field($model, 'unit_id') ?>

    <?php // echo $form->field($model, 'department_id') ?>

    <?php // echo $form->field($model, 'ecode') ?>

    <?php // echo $form->field($model, 'training_startdate') ?>

    <?php // echo $form->field($model, 'training_enddate') ?>

    <?php // echo $form->field($model, 'trainig_topic_id') ?>

    <?php // echo $form->field($model, 'batch_id') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

   
    <?php ActiveForm::end(); ?>

</div>
