<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

#echo $model->offerletter;
$form = ActiveForm::begin(			
            ['action' => ['porec-training/sendofferletter'],'layout' => 'horizontal']);  ?>
<div id="offerletter_grid" class="col-lg-12">
		<input type="hidden" name="recruitment_id" id="recruitment_id" value="" />
		 <?= $form->field($model, 'offerletter')->widget(CKEditor::className(), [
			'options' => ['rows' => 10],		
			'preset' => 'full',				
		]) ?>  
		<!--<textarea id="offerletter" name="offerletter"></textarea>-->
</div>


<br>
<div class="form-group">
  <div class="col-lg-5"> </div>
  <div class="col-lg-3"> <?= Html::submitButton('SendOfferLetter', ['class' => 'btn-sm btn-success','id' => 'send_offer', 'value'=>'Send Offer Letter']) ?></div>
</div>
<?php ActiveForm::end(); ?>

<?php 
$script = <<< JS
$('#send_offer').click(function(){
	//alert('hi');
	var offer_date	=	$('#recruitment-offer_date').val();
	
	if(offer_date	==	''){
		$('.help-block-error').text('Enter Offer Date');
		return false;
	}
});

JS;
$this->registerJs($script);
?>