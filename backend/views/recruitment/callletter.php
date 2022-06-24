<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Generate Call Letter';
$this->params['breadcrumbs'][] = ['label' => 'Recruitment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php #echo $this->render('_search', ['model' => $searchModel]); ?>
</br>
<?php echo $this->render('_calllettersearch', ['model' => $searchModel]); ?>
<div class="recruitment-index">
<!--<div class="panel panel-default">
	
	<div class="panel-heading text-left" style="font-size: 15px;"> Generate Call Letter</div>
	<div class="panel-body">  
    <!--<h1><?= Html::encode($this->title) ?></h1> 
	<p>
	<?= Html::a('Process Status', ['recruitmentprocess'], ['class' => 'btn-sm btn-primary']) ?>
	</p>-->
	
	</br>
	<div class="row">  
      <div class="pull-left" style="padding-left: 50px">
		<?= Html::a('Process Status', ['recruitmentprocess'], ['class' => 'btn-sm btn-primary']) ?>		
      </div>
	</div>
	
  <br>  
  <br>  
  <?php $form = ActiveForm::begin(			
            ['action' => ['recruitment/sendcallletter'],'layout' => 'horizontal']); ?>
		<div class="row" style="float: center;" >
			<div class="col-md-6" style="float: right; align: right;">
				<?= $form->field($searchModel, 'mail_option')->dropDownList([ 'sendmail' => 'Send Mail', 'alreadysent' => 'Mail Already Sent',], ['prompt' => 'Mail Option']) ?></div>
		</div>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'id' => 'grid',	
		'panel' => [
           'type' => 'info',		   
           'heading' => '<h3 class="panel-title">Generate Call Letter</h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[ 'class' => 'yii\grid\CheckboxColumn',
				'checkboxOptions' => ["attribute" => 'id'],
			],
			'register_no',
			#'type',
            'name',
            'qualification',
            'specialization',
            'year_of_passing',
            'selection_mode',
			'referred_by',
            'position',
            'contact_no',
            #'status',			
            //'rejected_reason:ntext',
            //'resume',
            /*['class' => 'yii\grid\ActionColumn',
			
			],*/
        ],
    ]); ?>
	
	
	<div id="callletter_content" style="display: none;">
		<?= $form->field($searchModel, 'callletter')->widget(CKEditor::className(), [
			'options' => ['rows' => 10],		
			'preset' => 'full',		
		]) ?>
	</div>
   
	<div class="col-md-1" style="left:600px;">
		<input type="submit" name="sendcallletter" id="sendcallletter" class="btn-sm btn-success" value="Send Call Letter" >
	</div>
	<!--<button type="button" name ="sendcallletter" id ="sendcallletter" class="btn-xs btn-success pull-right">Send Call Letter</button>-->
	
	<!--<div class="col-md-5 alert alert-success" id="report_sucess"></div>
    <div class="col-md-1"></div>
    <div class="col-md-5 alert alert-danger" id="report_failure" ></div>-->
	<?php ActiveForm::end(); ?>
<!--</div>
</div>-->
</div>
<?php
$script = <<< JS
	$('input[type="checkbox"]').change(function() {
		if ($(this).is(':checked')) {
			$("#sendcallletter").focus();
			$('#callletter_content').show();
		}
	});
	
	$('#sendcallletter').click(function(){
		var mail_option	=	$('#calllettersearch-mail_option').val();
		var checklen	=	$('input[type="checkbox"]:checked').length;
		
		if(checklen == 0){
			alert('choose the name to send the call letter!!!');
			return false;
		}
		
		if(mail_option == ''){
			alert('Choose Mail Option!!!');
			$('#calllettersearch-mail_option').focus();
			return false;
		}
	});	
JS;
$this->registerJs($script);
?> 