<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<div class="recruitmentbatch-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>	
   
	 <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [    
	 'options' => ['class' => 'form-control'],
		'dateFormat' => 'dd-MM-yyyy',
	]) ?>
    <?= $form->field($model, 'batch_name')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
     <div class="col-lg-4" style="left:10px;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn-sm btn-primary' : 'btn btn-primary', 'id' => 'BatchCreate']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
        
$('#BatchCreate').click(function(event){        
	 event.preventDefault();
    $('#modalbatch').modal('hide'); 
        var date = $('#recruitmentbatch-date').val();
		 var name = $('#recruitmentbatch-batch_name').val();
        $.get('batchstore',{ date : date, name : name },function(data){
		$('#recruitment-batch_id').html(data);
	});
        
});
JS;
$this->registerJs($script);
?>
