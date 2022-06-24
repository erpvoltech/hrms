<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingFaculty */
/* @var $form yii\widgets\ActiveForm */
use common\models\EmpDetails;
use yii\helpers\ArrayHelper;
$ecodeData = ArrayHelper::map(EmpDetails::find()->all(),'empcode','empcode');
?>

<div class="training-faculty-form">
  <Br>
    <?php $form = ActiveForm::begin(
            ['layout' => 'horizontal']
            ); ?>    
	
	<?= $form->field($model, 'faculty_ecode')->dropDownList($ecodeData,
        ['prompt'=>'Select...']) ?>

    <?= $form->field($model, 'faculty_name')->textInput(['maxlength' => true]) ?>
  <br>
    <div class="form-group">
      <div class="col-lg-5" ></div>
      <div class="col-lg-3" ><?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
    </div>
	
    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS

$("#trainingfaculty-faculty_ecode").change(function(){
	var faculty_ecode	=	$("#trainingfaculty-faculty_ecode").val();
	
	$.post("ajax-ecode",{'faculty_ecode':faculty_ecode},function(data){		
		$("#trainingfaculty-faculty_name").val(data);			
		$("#trainingfaculty-faculty_name").attr('readonly', 'true');
	});	
});
JS;
$this->registerJs($script);
?>
