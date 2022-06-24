<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Recruitment;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "Recruitment";
$this->params['breadcrumbs'][] = $this->title;
$model = new Recruitment();
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
</br>
<div class="recruitment-index">
	<!--<div class="panel panel-default">-->
	<!--<div class="panel-heading text-left" style="font-size: 15px;"> Recruitments</div>-->
	<!--<div class="panel-body">  
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id' => 'pjax-calllettergenerate']); ?>
  
    <p>
        <?= Html::a('Create Recruitment', ['create'], ['class' => 'btn-sm btn-primary']) ?>
		<?= Html::a('Call Letter', ['sendcallletter'], ['class' => 'btn-sm btn-primary']) ?>
	</p>	-->
		<?php #echo $this->render('_filter', ['model' => $filterModel]); ?>
		<!--<div style="float:right;">&nbsp;&nbsp;<button id="export" class="btn btn-default"  title=Export data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Export </button></div>
		<div style="float:right;"><button id="export_template" class="btn btn-default"  title=Template data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Template </button></div>
		<div class="col-md-1" style="float:right;"> <a class="btn btn-info" href="<?= \Yii::$app->homeUrl ?>recruitment/import" style="color:#fff;">Import</a></div>
		--->
	<div class="row">  
      <div class="pull-left" style="padding-left: 50px">
        <?= Html::a('Create Recruitment', ['create'], ['class' => ' btn-sm btn-success']) ?>
		<?= Html::a('Call Letter', ['sendcallletter'], ['class' => 'btn-sm btn-primary']) ?>
      </div>
	</div>
	</BR></BR>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'id' => 'grid',	
		'toolbar' => [
           '<button id="export" class="btn btn-default"  title=Export Data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Export </button>',
			'<button id="export_template" class="btn btn-default"  title=Export Template"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Template </button>',
			'<a class="btn btn-default" href="'.\Yii::$app->homeUrl.'recruitment/import" ><i class="glyphicon glyphicon-import"></i>Import</a>'
		],
		'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Recruitment Details</h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			/*[ 'class' => 'yii\grid\CheckboxColumn',
				'checkboxOptions' => ["attribute" => 'id'],
			],*/
			'register_no',
			#'type',
            'name',
			'type',
            'qualification',
            'specialization',
            #'year_of_passing',
            'selection_mode',
			'referred_by',
            'position',
            'contact_no',
            'status',			
            [
             'label'=>'Callletter',
             'format'=>'raw',
             'value' => function($model, $key, $index, $column) { return $model->callletter_status == 0 ? '-' : 'Sent';},
            ],
			'process_status',			
            //'rejected_reason:ntext',
            //'resume',

            ['class' => 'yii\grid\ActionColumn',
			
			],
        ],
    ]); ?>
	
   <?php Pjax::end(); ?>  
	
	<!--<button type="button" name ="sendcallletter" id ="sendcallletter" class="btn-xs btn-success pull-right" >Send Call Letter</button>-->
	<div class="col-md-5 alert alert-success" id="report_sucess"></div>
    <div class="col-md-1"></div>
    <div class="col-md-5 alert alert-danger" id="report_failure" ></div>	
<!--</div>
</div>-->

</div>
<?php
        $script = <<<JS
		
		$('#report_sucess').hide();
		$('#report_failure').hide();
		
	$("#importButton").click(function(){
		//alert("hi");
		$("#recruitmentimport-form").css('display','block');
	})
	
	/*$("input[name='selection']:checked").change(function() {
		alert("ghi");
		$("#sendcallletter").show();
    })*/

/*$('#sendcallletter').click(function(event){
	alert("hi");
      var dialog = confirm("Are you sure to Send Call Letter?");
      if (dialog == true) {		
        var keys = $('#grid').yiiGridView('getSelectedRows'); 
		
		//var formdata	=	{'keylist' : keys, 'callletter_status' : 1};

		//alert(keys);
		
		$.post('recruitment/sendcallletter',{'keylist' : keys},function(output){
			alert(output);
		});*/
      
        /*$.ajax({
			type: "POST",
            url: 'recruitment/sendcallletter',
            data: {'keylist' : keys},
            //data: {'keylist' : keys, 'callletter_status' : 1},
			dataType: 'json',
                  success: function(d){			 
				$.each(d.success, function(i,report) {
				$('#report_sucess').show();
					$('#report_sucess').append(report);
				});
				$.each(d.error, function(i,report) {
				$('#report_failure').show();
					$('#report_failure').append(report);
				}); 
				$.pjax.reload({container: '#pjax-calllettergenerate'}); 				
               }
             });*/
         /*}
      });*/
	  
	  $("#export").click(function() {
			var search	=	$("#recruitmentsearch-search").val();
			var type	=	$("#recruitmentsearch-type").val();
			var batch	=	$("#recruitmentsearch-batch_id").val();
			var printWindow = window.open('export?search='+search+'&type='+type+'&batch='+batch, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
			printWindow.document.title = "Downloading";

							printWindow.addEventListener('load', function () {

							}, true);
		});
		
		$("#export_template").click(function() {
			var printWindow = window.open('export_template', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
			printWindow.document.title = "Downloading";

							printWindow.addEventListener('load', function () {

							}, true);
		});
	  
JS;
		$this->registerJs($script);
        ?> 