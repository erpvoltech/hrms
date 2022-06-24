<?php
use yii\helpers\Html;
use common\models\EmpPromotion;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\Designation;
use yii\widgets\ActiveForm;

error_reporting(0);

require __DIR__ . '/../../../vendor/richtexteditor/include_rte.php';
?>
 
  <style>
	.buttonOne {
    align-items: flex-start;
    text-align: center; 
    border-width: 2px;
    border-style: outset;
    border-color: buttonface;
    border-image: initial;
	text-rendering: auto;   
    letter-spacing: normal;
    word-spacing: normal;   
    text-indent: 0px;
    text-shadow: none;
    display: inline-block;   
}
.editorBodyContent{
	font-family:Century Gothic;
	font-size:14px
}
</style>
 
 <div class="emp-appointment-view editorBodyContent">
 <?php $form = ActiveForm::begin(); ?>
	 <?php
	$model = EmpPromotion::find()->where(['id'=>$_GET['id']])->one();
	$Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
	$EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Emp->id])->one();
	
			if($EmpPersonal->gender == 'Male') {
				$salutation ='Mr. ';
			} elseif($EmpPersonal->gender == 'Female') {
				$salutation ='Ms. ';
			} else {
				$salutation = 'Dear ';
			}	
	
			if($_GET['type'] == 'promotion') {
			$DesignationFrom = Designation::find()->where(['id'=>$model->designation_from])->one();
			$DesignationTo = Designation::find()->where(['id'=>$model->designation_to])->one();				
			
			
			$document_letter ='<br></br>
			
			<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</b></p>
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$DesignationFrom->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Job Promotion &#x2010; Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			
			<p>With high appreciations, The Management would like to inform that, you have been promoted to the post of <strong>&ldquo;'.$DesignationTo->designation.'&rdquo;</strong> under <strong>'.$model->wl_to.$model->grade_to.'</strong>. 
			This promotion is a result of the passion and commitment you have been exhibiting in your existing role. Your revised remuneration shall be as per the Annexure &lt;&lt;<strong><a href="http://vepl.voltechgroup.com/hrms/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>.  </p>
			
			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").'</strong> and your previous improvement letter dated <strong>'.Yii::$app->formatter->asDate($Emp->recentdop, "dd-MM-yyyy").'<strong>.
			We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';				
			
			} else 	if($_GET['type'] == 'inc') {
			
			$Designation = Designation::find()->where(['id'=>$Emp->designation_id])->one();
	   			
			$document_letter ='<br></br>
			
			<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</b></p>
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$Designation->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Increment in the Remunerations – Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			
			<p>With high appreciations, The Management would like to inform that, your remunerations has been hiked to Work Level <strong>'.$model->wl_to.$model->grade_to.'</strong>. This Increment is a result of the passion and commitment you have been exhibiting in your existing role.</p>

			<p>Your revised remuneration shall be as per the annexure &lt;&lt;<strong><a href="http://vepl.voltechgroup.com/hrms/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>. </p>

			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").'</strong> and your earlier improvement letter dated <strong>'.Yii::$app->formatter->asDate($Emp->recentdop, "dd-MM-yyyy").'</strong>. </p>

			<p>We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>
			
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';					
			
			} else 	if($_GET['type'] == 'confirm') {
			
			if(!empty($model->designation_to)){
				$DesignationTo = Designation::find()->where(['id'=>$model->designation_to])->one();	
			} else{
				$DesignationTo = Designation::find()->where(['id'=>$Emp->designation_id])->one();
			}
			$DesignationFrom = Designation::find()->where(['id'=>$model->designation_from])->one();
			
			$document_letter ='<br></br>
			
			<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</b></p>
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$DesignationFrom->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Confirmation and Promotion of Job – Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			<p>With high appreciations, The Management would like to inform that, you have been confirmed and Promoted to the post of <strong>“'.$DesignationTo->designation.'”</strong>. This confirmation is a result of careful appraisal of your performance during your probation period and the promotion is awarded for the passion and commitment you have been exhibiting in your existing role.</p> 

			<p>Your revised remuneration shall be as per the Annexure &lt;&lt;<strong><a href="http://vepl.voltechgroup.com/hrms/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>. </p>

			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").'</strong>. </p>

			<p>We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>

			
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';						
			}
			 
			
			
                // Create Editor instance and use Text property to load content into the RTE.  
                $rte=new RichTextEditor();   
                $rte->Text=$document_letter; 				
                // Set a unique ID to Editor   
                $rte->ID="Editor1";    
                $rte->MvcInit();   
                // Render Editor 
                echo $rte->GetString();  
            ?>  	
			
			<br>
			 <!--<div class="form-group">
			<div class="col-md-2">
			  <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?>
			</div> <div class="col-md-3">			   
			   <?= Html::a('View PDF',['appointmentpdf?id='.$_GET['id']], ['target' => '_blank','class' => 'buttonOne btn-sm btn-danger']) ?>
			</div>
			<div class="col-md-2">			   
			   <?= Html::a('Send Mail',['appointment-mail?id='.$_GET['id']], ['class' => 'buttonOne btn-sm btn-primary']) ?>
			</div>
			<div class="col-md-3">			   
			Before Send Mail, View in PDF. This PDF format is attached to Mail.
			</div>
		</div> -->
			
			
		    <?php ActiveForm::end(); ?>	 
  </div>
  
   