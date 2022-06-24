<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\models\Unit;
use app\models\Department;
use app\models\Designation;
use app\models\EmpAddress;
#use app\models\AppointmentLetter;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;
error_reporting(0);

if (Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"])
		   $unit = Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"];
		else
		   $unit = NULL; 

if (Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"])
		   $design = Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"];
		else
		   $design = NULL; 
	   
if (Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"])
	   $dept = Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"];
else
	$dept = NULL; 
?>

<style>
   .glyphicon {
      padding-right:10px;
   } table{
      background-color:#DFDFDF;
   }
</style>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="emp-details-index" >

   <div class="row">  
      <div class="pull-left" style="padding-left: 50px">
         <?= Html::a('Create Emp Details', ['create'], ['class' => ' btn-sm btn-success']) ?>
      </div>
   </div>
   <br><br></br>
   <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(			
				['action' => ['verifyecode'],'method' => 'post','layout' => 'horizontal',
				]); ?>   
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       'toolbar' => [
	   
            '<button id="verify" class="btn btn-success"  title=Verify">
			Verify </button>',
			/*
			'<button id="export" class="btn btn-default"  title=Export data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Export </button>'*/
			
       ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Employee Details</h3>',
       ],
       'columns' => [
			   ['class' => 'yii\grid\SerialColumn'],
			   'empname',
			   'doj',
			   [
				   'attribute' => 'designation_id',
				   'value' => 'designation.designation',
			   ],           
			   [
				   'attribute' => 'unit_id',
				   'value' => 'units.name',
			   ],
			   [
				   'attribute' => 'department_id',
				   'value' => 'department.name',
			   ],
			   //'worktype',
			   //'email:email',
			   //'alternativeemail:email',
			   //'mobileno',
			   //'alternativemobileno',
			   //'referedby',
			   //'probation',
			   //'appraisalmonth',
			   //'recentdop',
			   //'dateofleaving',
			   //'reasonforleaving:ntext',
			   //'photo',
				[ 'label' => 'Consolidated',
				   'format' => 'raw',
				   'value' => 'consolidated_status',			   
				],
				
				[
					'class' => 'yii\grid\CheckboxColumn',
					'header' => Html::checkBox('selection_all', false, [
						'class' => 'select-on-check-all',
						'label' => 'Check All',
					]),
					
				],
				
				[
				   'class' => 'yii\grid\ActionColumn',
				   'template' => '{view} {update}   {delete} ',						
				],
            ],
           ]);
           ?>
		   <?php ActiveForm::end(); ?>
           <?php Pjax::end(); ?>
           <?php
           $script = <<<JS
			 $("#export").click(function() {
				var printWindow = window.open('export?unit=$unit&design=$design&dept=$dept', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
								printWindow.addEventListener('load', function () {
								}, true);
			});
JS;
           $this->registerJs($script);
           ?>
</div>