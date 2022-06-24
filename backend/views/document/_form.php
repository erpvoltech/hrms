<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\ckeditor\CKEditor;
use common\models\EmpAddress;
use common\models\EmpDetails;
use common\models\EmpFamilydetails;
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
</style>
<div class="emp-document">

    <?php $form = ActiveForm::begin();
		//$model->document= $document;
		$model->type= $type;
		//$model->empid= $empid;
		   
                // Create Editor instance and use Text property to load content into the RTE.  
                $rte=new RichTextEditor();   
                $rte->Text=$document; 
                // Set a unique ID to Editor   
                $rte->ID="Editor1";    
                $rte->MvcInit();   
                // Render Editor 
                echo $rte->GetString();  
           	
      /*  $form->field($model, 'document')->widget(CKEditor::className(), [
        'options' => ['rows' => 7],		
        'preset' => 'full',		
    ])->label(false) */
	?>     </br>
		<div class="form-group">
			<div class="col-md-2">
			  <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?>
			</div> <div class="col-md-3">			   
			   <?= Html::a('View PDF',['viewpdf?id='.$_GET['id']], ['target' => '_blank','class' => 'buttonOne btn-sm btn-danger']) ?>
			</div>
			<div class="col-md-3">			   
			   <?= Html::a('Without-Header',['without-header?id='.$_GET['id']], ['target' => '_blank','class' => 'buttonOne btn-sm btn-danger']) ?>
			</div>
			<div class="col-md-2">			   
			   <?= Html::a('Send Mail',['send-mail?id='.$_GET['id']], ['target' => '_blank','class' => 'buttonOne btn-sm btn-primary']) ?>
			</div>
			<div class="col-md-3">			   
			Before Send Mail, View in PDF. This PDF format is attached to Mail.
			</div>
		</div>
		<br>
		
		
		
    <?php ActiveForm::end(); ?>
	<br><br>
	<?php if($model->type == 3){	
	$document_letter ='';
	$Emp = EmpDetails::findOne($model->empid);
	$empadd = EmpAddress::find()->where(['empid' => $Emp->id])->one();
	$fmaily = EmpFamilydetails::find()->where(['empid' => $Emp->id])->all();
	foreach($fmaily as $fam){
	if(strtolower($fam->relationship) =='father')
		$fathername = $fam->name; 
		}
		$document_letter .= '<strong>' . $Emp->empname . ',</strong><br />';
		if(!empty($fathername)){
		$document_letter .= '<strong>' .$fathername.'</br>';	
			}
		if ($empadd->addfield1 != '')
				$document_letter .= '<strong>' . $empadd->addfield1 . ',</strong><br />';
				if ($empadd->addfield2 != '')
				$document_letter .='<strong>' . $empadd->addfield2 . ',</strong><br />';
				if ($empadd->addfield3 != '')
				$document_letter .='<strong>' . $empadd->addfield3 . ',</strong><br />';
				if ($empadd->addfield4 != '')
				$document_letter .='<strong>' . $empadd->addfield4 . ',</strong></br>';
				if ($empadd->addfield5 != '')
				$document_letter .='<strong>' . $empadd->addfield5 . ',</strong></br>';
				if ($empadd->district != '')
					$document_letter .='<strong>' . $empadd->district . ',</strong></br>';
				if ($empadd->state != '')
					$document_letter .='<strong>' . $empadd->state . ' </strong>';
				if ($empadd->pincode != '')
					$document_letter .=' - <strong>' . $empadd->pincode . ',</strong></br>';
				
				if ($Emp->mobileno != '')
					$document_letter .='<strong>Mobile No.  ' . $Emp->mobileno . '.</strong></br>';
			
			echo $document_letter;
	}
	?>  	
</div>

