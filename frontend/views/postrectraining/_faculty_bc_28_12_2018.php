<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TrainingFaculty;
use app\models\PorecTrainingSearch;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTrainingSearch */
/* @var $form yii\widgets\ActiveForm */

$facultyData=ArrayHelper::map(TrainingFaculty::find()->all(),'id','faculty_name');
$model = new TrainingFaculty();
$searchModel = new PorecTrainingSearch();
?>

<style>
.form-control{ width: auto;}
</style>

<div class="porec-training-print1">
    <?php $form = ActiveForm::begin([
        'action' => ['print1'],
        'method' => 'post',
		'layout' => 'horizontal'
    ]); ?>
	<br>
	<div class="row">
	<div class="form-group col-lg-7"></div>
	<div class="form-group col-lg-3">		
	<?php 		
	#echo "<pre>";print_r($_REQUEST);echo "</pre>"; 
	
	if(isset($_REQUEST['PorecTrainingSearch']['batch_id']) && $_REQUEST['PorecTrainingSearch']['batch_id'] != ''){
		$batch_id 			= $_REQUEST['PorecTrainingSearch']['batch_id'];
	}else{
		$batch_id 			= '';
	}
	if(isset($_REQUEST['PorecTrainingSearch']['trainig_topic_id']) && $_REQUEST['PorecTrainingSearch']['trainig_topic_id'] != ''){
		$training_topic_id 	= $_REQUEST['PorecTrainingSearch']['trainig_topic_id'];
	}else{
		$training_topic_id 	=	'';
	}
	
	#echo "<pre>";print_r($batch_id);echo "</pre>";
	#echo "</br> batch_id: ".$batch_id;
	#echo "</br> training_topic_id: ".$training_topic_id;
	?>
	<?= $form->field($model, 'batch_id')->hiddenInput(['value'=>$batch_id])->label(false); ?>
	<?= $form->field($model, 'training_topic_id')->hiddenInput(['value'=>$training_topic_id])->label(false); ?>
	<?= $form->field($model, 'faculty_name')->dropDownList($facultyData,
        ['prompt'=>'Select...']) ?>
	<?= $form->field($model, 'print_type')->dropDownList(
        ['print1'=>'attendance','print2'=>'feedback','print3'=>'feedback effectiveness'],['prompt'=>'Select...']) ?>
	
</div>
    <div class="form-group col-lg-2">
        <?= Html::submitButton('Print', ['class' => 'btn btn-success']) ?>
        <?php //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS

$("#trainingfaculty-print_type").on('change', function() {
	var actionval	=	'/hrmis/frontend/web/index.php?r=postrectraining%2F'+this.value;
    $(this.form).attr("action", actionval);
});

JS;
$this->registerJs($script);
?>