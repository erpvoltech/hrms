<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\spinner\Spinner;
?>
<style>
   .alert {
      padding: 5px;
      margin-bottom: 8px;
   }
</style>
<div class="emp-salary-form">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;">Set New Salary Month</div>
      <div class="panel-body"> 
         <?php
         $form = ActiveForm::begin([                   
                     'layout' => 'horizontal',
         ]);
         ?>
         <br>  

         <div class="row">
            <div class="form-group col-lg-4 "></div>
            <div class="form-group col-lg-4 ">
               <?=
               $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'dateFormat' => 'MM-yyyy',
               ])
               ?> 
            </div>            
         </div>        
         <br>
          
         <div class="row">
            <div class="form-group col-lg-4" ></div>
            <div class="form-group col-lg-3" >
              <button type="button" name ="setnewmonth" id ="setnewmonth" class="btn btn-success pull-right">Submit</button>
            </div>
         </div>
         <br>	
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
		  <div class="col-md-5 alert alert-success" id="report_sucess"></div>
           <div class="col-md-1"></div>
           <div class="col-md-5 alert alert-danger" id="report_failure" > </div>
        </div>
		 
         <?php ActiveForm::end(); ?>
      </div>
   </div>
</div>
<?php
   $script = <<<JS
   $('#report_sucess').hide();
	$('#report_failure').hide();
	$('#loding').hide();
  $('#setnewmonth').click(function(event){
  $('#setnewmonth').hide();	 
      var dialog = confirm("Are you sure to Generate Salary?");
      if (dialog == true) {
	   var keys = $('#empsalaryupload-month').val();  
		$('#loding').show();
        $.ajax({
			type: "POST",
            url: 'add-month',
            data: {month: keys},
			dataType: 'json',
                success: function(data){
				if(data.success == 'generated'){
				$('#loding').hide();
					window.location.href='salarygenerate';
				} else if(data.error == 'uploaded error'){
				$('#report_failure').show();
				$('#report_failure').append('Current Salary Process Not Completed...');
					$('#loding').hide();
				} else if(data.error == 'Already Generated'){ 
				$('#report_failure').show();
				$('#report_failure').append('Salary Month Already Generated');
					$('#loding').hide();
				} else {
				$('#report_failure').show();
				$('#report_failure').append('Something Error');
				$('#loding').hide();
				}
               }
            });
         }
      });
 
JS;
        $this->registerJs($script);
        ?>     
