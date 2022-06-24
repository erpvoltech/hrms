<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\spinner\Spinner;
error_reporting(0);
?>

<?php echo $this->render('_hrsearch', ['model' => $searchModel]); ?>
<br><br>


<div class="emp-salary-index">
<div class="row">
<div class="col-lg-5 " id="report_amount1"></div>
<div class="col-lg-2 alert alert-success" id="report_amount"></div>
</div>
<div class="row" id="loding">
            <div class="form-group col-lg-4 "></div>
            <div class="form-group col-lg-4 ">
            <?=Spinner::widget([
			'preset' => Spinner::LARGE,
			'color' => 'blue',
			'align' => 'center',
			'caption' => 'Please wait &hellip;'
		])?>
            </div>            
         </div>

	 
		
   <br>
   <?php 
	   Pjax::begin(['id' => 'pjax-index']); ?> 

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'toolbar' => [
    ],
    'panel' => [
	           
        'type' => 'info',
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Employee Salary Details</h3>',
    ],
	 'id' => 'grid',
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           [ 'class' => 'yii\grid\CheckboxColumn',
               'checkboxOptions' => ["attribute" => 'id'],
           ],
        [
            'attribute' => 'empid',
            'value' => 'employee.empcode',
        ],
        'employee.empname',
        'designations.designation',
        [
            'attribute' => 'unit',
            'value' => 'employee.units.name',
        ],
        [
            'attribute' => 'department',
            'value' => 'employee.department.name',
        ],
        [
            'header' => 'Month',
            'value' => 'month',
            'format' => ['date', 'php: M Y']
        ],
        'basic',
        'hra',        
        [
            'header' => 'DA',
            'value' => 'dearness_allowance',
        ],
		'other_allowance',
		'earnedgross',
        'net_amount',
        //'over_time',
        //'arrear',
        //'guaranted_benefit',
        //'dust_allowance',
        //'performance_pay',
        //'other_allowance',
        //'pf',
        //'insurance',
        //'professional_tax',
        //'esi',
        //'advance',
        //'tes',
        //'other_deduction',
        /*['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
        ],*/
    ],
]);
?>
 <?php Pjax::end(); ?>
	<div class="row">
		   <div class="col-md-5"> </div>
			   <div class="col-md-2"> <!-- <button type="button" name ="generateall" id ="generateall" class="btn-xs btn-success pull-right">Generate All</button>--></div>
			   <div class="col-md-2">  <button type="button" name ="finapproval" id ="finapproval" class="btn-xs btn-success pull-right">Salary Approval</button></div>
		   </div>
          
       <div class="col-md-5 alert alert-success" id="report_sucess"></div>
           <div class="col-md-1"></div>
           <div class="col-md-5 alert alert-danger" id="report_failure" ></div>
</div>
<?php
 $script = <<<JS
 
   
  
  
	$('#report_sucess').hide();
	$('#report_amount').hide();
	$('#report_failure').hide();
	$('#loding').hide();
	
	  
	$(".select-on-check-all").change(function(){
	var keys = [];
	keys = $('#grid').yiiGridView('getSelectedRows');  		

      $.ajax({
			type: "POST",
			
            url: 'totamounthr',
            data: {keylist: keys},
			dataType: 'json',
                  success: function(data){	
					$('#report_amount').show();
					$('#report_amount').html(data);
					$('#loding').hide();
				},
             });
			 
	  });
		   
	 
	
	 
      $('#finapproval').click(function(event){
      var dialog = confirm("Are you sure to Approve Salary?");
      if (dialog == true) {
	  $('#loding').show();
        var keys = $('#grid').yiiGridView('getSelectedRows');  		 
      
        $.ajax({
			type: "POST",
			
            url: 'finapprovalhr',
            data: {keylist: keys},
			dataType: 'json',
                  success: function(data){			 
				$.each(data.success, function(i,report) {
				$('#report_sucess').show();
					$('#report_sucess').append(report);
					$('#loding').hide();
				});
				$.each(data.error, function(i,report) {
				$('#report_failure').show();
					$('#report_failure').append(report);
					$('#loding').hide();
				}); 
				$.pjax.reload({container: '#pjax-index'});	
               }
             });
         }
      });
  
  
 

	

JS;
        $this->registerJs($script);
        ?>     


