<?php
use common\models\EmpPromotion;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\Designation;
?>
 <div class="alert alert-success" id="report_sucess"></div>
	<?php
	$model = EmpPromotion::find()->where(['email_flag'=>1])->all();	
		echo '<table>';	
		$i=1;
		$x =1;
		$y=1;
		echo '<h1>Promotion List</h1>';
		foreach ($model as $promomodel) {
		$Emp = EmpDetails::find()->where(['id' => $promomodel->empid])->one();
			if($promomodel->type == 1) {	   
				
			    $type ='promotion'; 
				$DesignationFrom = Designation::find()->where(['id'=>$promomodel->designation_from])->one();
				$DesignationTo = Designation::find()->where(['id'=>$promomodel->designation_to])->one();
			
			    echo '<tr><td>'.$i.'</td>'.
				'<td><input type="checkbox" name="promotion_id[]" id="promotion'.$promomodel->id.'" value="'.$promomodel->id.'"></td>'.
				'<td>'.$Emp->empcode.'</td>'.
				'<td>'.$Emp->empname.'</td>'.
				'<td>'.$DesignationFrom->designation.' --> '.$DesignationTo->designation.'</td>'.
				'<td>'.$promomodel->wl_from.' --> '.$promomodel->wl_to.'</td>'.
				'<td>'.$promomodel->grade_from.' --> '.$promomodel->grade_to.'</td>'.
				'<td><a href="promotion-create?id='.$promomodel->id.'&type='.$type.'"> View</a></td>'.
				'</tr>';
				$i++;
			} 
		}
		echo '</table>';	
		echo '<br>';
		echo '<h1>Increment List</h1>';
		echo '<table>';	
		
		foreach ($model as $promomodel) {
		$Emp = EmpDetails::find()->where(['id' => $promomodel->empid])->one();
			if($promomodel->type == 2) { 
				
			    $type ='inc';
				$Designation = Designation::find()->where(['id'=>$Emp->designation_id])->one();
				
				echo '<tr><td>'.$x.'</td>'.
				'<td><input type="checkbox" name="inc_id" id="inc'.$promomodel->id.'" value="'.$promomodel->id.'"></td>'.
				'<td>'.$Emp->empcode.'</td>'.
				'<td>'.$Emp->empname.'</td>'.
				'<td>'.$Designation->designation.'</td>'.
				'<td>'.$promomodel->wl_from.' --> '.$promomodel->wl_to.'</td>'.
				'<td>'.$promomodel->grade_from.' --> '.$promomodel->grade_to.'</td>'.
				'<td><a href="promotion-create?id='.$promomodel->id.'&type='.$type.'"> View</a></td>'.
				'</tr>';
				$x++;
			}
		}
		echo '</table>';
		echo '<br>';
		echo '<h1>Confirmation List</h1>';
		echo '<table>';		
		foreach ($model as $promomodel) {
			if($promomodel->type == 3) {
			
			$type ='confirm';
			$Emp = EmpDetails::find()->where(['id' => $promomodel->empid])->one();
				if(!empty($model->designation_to)){
					$DesignationTo = Designation::find()->where(['id'=>$model->designation_to])->one();	
				} else{
					$DesignationTo = Designation::find()->where(['id'=>$Emp->designation_id])->one();
				}
				
				echo '<tr><td>'.$y.'</td>'.
				'<td><input type="checkbox" name="confirm_id" id="confirm'.$promomodel->id.'" value="'.$promomodel->id.'"></td>'.
				'<td>'.$Emp->empcode.'</td>'.
				'<td>'.$Emp->empname.'</td>'.
				'<td>'.$DesignationTo->designation.'</td>'.
				'<td>'.$promomodel->wl_from.' --> '.$promomodel->wl_to.'</td>'.
				'<td>'.$promomodel->grade_from.' --> '.$promomodel->grade_to.'</td>'.
				'<td><a href="promotion-create?id='.$promomodel->id.'&type='.$type.'"> View</a></td>'.
				'</tr>';
				$y++;
			}		
		}
		echo '</table>';?>
<button type="button" name ="sendmail" id ="sendmail" class="btn-xs btn-success pull-right">sendmail</button>	
<?php		
$script = <<<JS
$('#report_sucess').hide();
$('#sendmail').click(function(event) {
 var dialog = confirm("Are you sure to Send Mail?");
      if (dialog == true) {
	  alert('Please Wait ...');
	  $('#loding').show();
       var array_values = [];
			$('input[type=checkbox]').each( function() {
				if( $(this).is(':checked') ) {
					array_values.push( $(this).val() );
				}
			});  		 
     
        $.ajax({
			type: "POST",
            url: 'promotion-mail',
            data: {keylist: array_values},			
            success: function(data){
				$('#report_sucess').show();
				$('#report_sucess').html(data);
				/*location.reload();*/				
			}
        });
    }
});
JS;
$this->registerJs($script);
?>
