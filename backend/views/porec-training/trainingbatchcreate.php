<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<div class="trainingbatch-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>	
   
	 <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [    
	 'options' => ['class' => 'form-control'],
		'dateFormat' => 'dd-MM-yyyy',
	]) ?>
    <?= $form->field($model, 'training_batch_name')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
		<div class="col-lg-4" style="left:10px;">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn-sm btn-primary' : 'btn btn-primary', 'id' => 'TrainingBatchCreate']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS
        
$('#TrainingBatchCreate').click(function(event){        
	 event.preventDefault();
    $('#TrainingModelBatch').modal('hide'); 
        var date = $('#trainingbatch-date').val();
		 var name = $('#trainingbatch-training_batch_name').val();
        $.get('trainingbatchstore',{ date : date, name : name },function(data){
		$('#porectraining-training_batch_id').html(data);
	});
        
});
JS;
$this->registerJs($script);
?>
