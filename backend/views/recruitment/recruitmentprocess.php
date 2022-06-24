<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Process Status';
$this->params['breadcrumbs'][] = ['label' => 'Recruitment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Call Letter', 'url' => ['sendcallletter']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php #echo $this->render('_search', ['model' => $searchModel]); ?>
</br>
<?php echo $this->render('_recruitmentprocesssearch', ['model' => $searchModel]); ?>
<div class="recruitment-index">
<!--<div class="panel panel-default">
	<div class="panel-heading text-left" style="font-size: 15px;"> Process Status</div>
	<div class="panel-body">  -->
    <!--<h1><?= Html::encode($this->title) ?></h1>    -->
	
  </br>
	<div class="row">  
      <div class="pull-left" style="padding-left: 50px">
		
      </div>
	</div>  
  <?php $form = ActiveForm::begin(			
            ['action' => ['recruitment/recruitmentprocess'],'layout' => 'horizontal']); ?>
  <!--<div style="width:30%">-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'id' => 'grid',	
		'panel' => [
           'type' => 'info',		   
           'heading' => '<h3 class="panel-title">Process Status</h3>',
        ],		
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\CheckboxColumn',
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
			[
             'label'=>'Callletter',
             'format'=>'raw',
             'value' => function($model, $key, $index, $column) { return $model->callletter_status == 0 ? '-' : 'Sent';},
            ],			
            //'rejected_reason:ntext',
            //'resume',

            /*['class' => 'yii\grid\ActionColumn',
			
			],*/
        ],
    ]); ?>
	<!--</div>-->
	<div id="checklen_error" style="color: #FF0000;"></div>
	<div class="row">
		<div class="col-md-4"><?= $form->field($searchModel, 'process_status')->dropDownList([ 'selected' => 'Selected', 'rejected' => 'Rejected', 'hold' => 'Hold', 'not attended' => 'Not attended', 'next batch' => 'Next Batch', 'others' => 'Others',]) ?><div id="prststatus_error" style="color: #FF0000;"></div></div>			
		<div class="col-md-4" id="ps_remarks" style="display: none;"><textarea name="process_statusremarks" id="remarks" rows="4" cols="50" placeholder="Remarks"></textarea></div>
		<div class="col-md-1" >
			<input type="submit" name="recruitmentprocess" id="recruitmentprocess" class="btn-sm btn-success" value="Submit" >
		</div>	
	</div>
	<!--<button type="button" name ="sendcallletter" id ="sendcallletter" class="btn-xs btn-success pull-right">Send Call Letter</button>-->
	
	<!--<div class="col-md-5 alert alert-success" id="report_sucess"></div>
    <div class="col-md-1"></div>
    <div class="col-md-5 alert alert-danger" id="report_failure" ></div>-->
	<?php ActiveForm::end(); ?>
<!--</div>-->
<!--</div>-->

</div>
<?php
$script = <<< JS

		$('#checklen_error').text('');
		$('#prststatus_error').text('');

	$('#recruitmentprocess').click(function(){
		var process_status	=	$('#recruitmentprocesssearch-process_status').val();
		var checklen		=	$('[name="selection[]"]:checked').length;
		$('#checklen_error').text('');
		$('#prststatus_error').text('');
		
		if(checklen == 0){
			$('#checklen_error').text('Choose anyone of the Name');
			return false;
		}
		
		if(process_status	==	''){
			$('#prststatus_error').text('Process status can not be empty');
			return false;
		}
	});
	
	$('#recruitmentprocesssearch-process_status').change(function(){
		var process_status		=	$('#recruitmentprocesssearch-process_status').val();
		
		if(process_status	==	'others' || process_status	==	'rejected'){
			$('#ps_remarks').show();
		}else{
			$('#ps_remarks').hide();
		}
	})
	
	/*$('input[name='selection']').click(function() {
		var checked = $(this).is(':checked');		
		alert('checked: '+checked);
	})*/
JS;
$this->registerJs($script);
?>