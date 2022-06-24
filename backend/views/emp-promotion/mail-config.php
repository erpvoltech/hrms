<?php
use common\models\MailCc;
use common\models\EmpDetails;
use common\models\Division;
use common\models\Unit;
use common\models\UnitGroup;	
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
//use kartik\depdrop\DepDrop;

$UnitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$DivData = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$EmpData = ArrayHelper::map(EmpDetails::find()->all(), 'id', 'empcode');
?>
<br>
<div class="row">
<div class="col-md-7">
<table>
	<tr>
		<th>Unit/Division</th><th>CC</th><th>BCC</th>
	</tr>
		
	<?php 	
	$UnitModel = Unit::find()->all();
	foreach($UnitModel as $unit){
	echo '<tr><td width="20%">'.$unit->name.'</td><td width="50%">';
	$Unitgroup = UnitGroup::find()->where(['unit_id'=>$unit->id])->all();
		foreach($Unitgroup as $group){
		$division = Division::find()->where(['id'=>$group->division_id])->one();
		echo '<b>'.$division->division_name .'</b> => ';
		$mailmodel = MailCc::find()->where(['unit'=>$unit->id,'division'=>$division->id])->all();
			foreach($mailmodel as $display){
				if($display->cc != '') {
				$Empcc = EmpDetails::find()->where(['id'=>$display->cc])->one();
				echo '<span style ="color:blue">'.$display->cc != '' ?$Empcc->empcode.'-'.$Empcc->empname.', ':''.'</span>';
				}
			}
			echo '<br>';
		}
		echo '</td><td width="30%">';
		foreach($Unitgroup as $ug){
		$division1 = Division::find()->where(['id'=>$ug->division_id])->one();	
		$mailmodel1 = MailCc::find()->where(['unit'=>$unit->id,'division'=>$division1->id])->all();
			foreach($mailmodel1 as $display1){
				if($display1->bcc != '') {
				$Empbcc = EmpDetails::find()->where(['id'=>$display1->bcc])->one();
				echo $display1->bcc != '' ?$Empbcc->empcode.'-'.$Empbcc->empname.', ':'';
				}
			}
			echo '<br>';
		}
		echo '</td></tr>';
	}
	
	?>
	

		
</table>
</div>

<div class="col-md-5">
  <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>
    <?= $form->field($model, 'unit')->widget(Select2::classname(), [
                                    'data' => $UnitData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]); ?>
	<?= $form->field($model, 'division')->widget(Select2::classname(), [
                                    'data' => $DivData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]); ?>   
	<?= $form->field($model, 'cc')->widget(Select2::classname(), [
                                    'data' => $EmpData,
                                    'options' => ['multiple' => true,'placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]); ?> 
	<?= $form->field($model, 'bcc')->widget(Select2::classname(), [
                                    'data' => $EmpData,
                                    'options' => ['multiple' => true,'placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]); ?> 
<div class="form-group">
  <div class="col-lg-5"style="padding-top:10px" > </div>
  <div class="col-lg-4" style="padding-top:20px" >   <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
 
</div>
    <?php ActiveForm::end(); ?>	
	<div class="col-lg-12" style="padding-top:50px"></div>
  <div class="col-lg-5" > </div>
  <div class="col-lg-4" >  <a href="mailconfig-index" style="color:#fff"> <button type="button" name ="edit" id ="edit" class="btn btn-primary ">Edit</button></div></a>
</div>