<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['index'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>

   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'empcode') ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
	  <div class=" col-lg-4"> <?= $form->field($model, 'division_id')->dropDownList($division, ['prompt' => 'Select...'])
   ?></div>
   </div>


   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'designation_id')->dropDownList($designation, ['prompt' => 'Select...'])
   ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'department_id')->dropDownList($deptData, ['prompt' => 'Select...'])
   ?></div>
   <div class=" col-lg-4">
         <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...']) ?> </div>
   </div>
   <div class="row">      
      <div class=" col-lg-4">
	  <?= $form->field($model, 'category')->widget(MultiSelect::className(),[
		 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 4
						], 
				]) ?></div>
        <div class=" col-lg-4"> <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Non-paid Leave' => 'Non-paid Leave', 'Paid and Relieved' => 'Paid and Relieved','Relieved' => 'Relieved','Transferred' => 'Transferred','Notice Period' => 'Notice Period','Termination' => 'Termination','Exit Formality Inprocess' => 'Exit Formality Inprocess'], ['prompt' => ' ']) ?> </div>
      </div>
    <div class="row">
        <div class=" col-lg-4">
            <?= $form->field($model, 'seektext')->textInput(['placeholder' => "Enter Your Text Here..."])->label('Search'); ?>
        </div>
        <div id="note"><a href="#" title="Search Tips">Note</a></div>
            <div id="TableData" style="display: none; font-size: 8pt;">
                <i style="color: red">City, District, State, Referred by, Father's Name, Mother's Name,
                Mobile No, Employee Name, Employee Code, Caste, Community, Blood Group, DoB</i>
            </div>
        <div class="col-lg-1"></div>
    </div>
        <div class="row">
            <div class=" col-lg-6"></div>
        <div class=" col-lg-1"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-1">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>	  
   <?php ActiveForm::end(); ?>
</div>
<br>

<?php
$script = <<< JS

$(document).ready(
    function() {
        $("#note").click(function() {
            $("#TableData").toggle();
        });
    });

JS;
$this->registerJs($script);
?>