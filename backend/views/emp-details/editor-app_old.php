<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use app\models\AppointmentLetter;
use common\models\Department;
use common\models\Designation;
use common\models\EmpRemunerationDetails;
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
                // Create Editor instance and use Text property to load content into the RTE.  
                $rte=new RichTextEditor();   
                $rte->Text=$model->letter; 				
                // Set a unique ID to Editor   
                $rte->ID="Editor1";    
                $rte->MvcInit();   
                // Render Editor 
                echo $rte->GetString();  
            ?>  	
			
			<br>
			 <div class="form-group">
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
		</div>
			
			
		    <?php ActiveForm::end(); ?>	 
  </div>
  
   