<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\EmpDetails;
use common\models\Division;
use common\models\AttendanceAccessRule;
use common\models\Status;

$empid = $_GET['id'];
$Emp = EmpDetails::find()->where(['id'=>$empid])->one();
$div = Division::find()->where(['id'=>$Emp->division_id])->one();
$sel_unit = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
//print_r($sel_unit);
$options = array();
$i=0;
foreach($sel_unit as $unit){
	$options[$i]=$unit->division;
	
	$i++;
	
}
$division = ArrayHelper::map(Division::find()->where(['id'=>$options])->all(), 'id', 'division_name');

?>
<div class="project-details-employee-transfer">

<?php $form = ActiveForm::begin(['layout' => 'horizontal']);?>
<br>
<div class="row">
<div class="col-md-2"> Name </div> 
<div class="col-md-2"> <?=$Emp->empname?> </div>
<div class="col-md-2"> Division/ Region </div>
<div class="col-md-2"> <?=$div->division_name?> 
<?= $form->field($model,'status_from')->hiddeninput(['value' => $Emp->status])->label(false); ?>
</div>
<div class="col-md-2"> Status </div> 
<div class="col-md-2"> <?=$Emp->status?> </div>
</div>
<br>
<div class="row">
<div class="col-md-2"> Status To </div>
<div class="col-md-2">  <?= $form->field($model, 'status_to')->dropDownList(
		['Active'=>'Active','Relieved'=>'Relieved','Non-paid Leave'=>'Non-paid Leave','Transferred'=>'Transferred','Paid and Relieved'=>'Paid and Relieved','Notice Period'=>'Notice Period'],
        ['prompt'=>'']
        )->label(false);?>

</div></div><br>
<div class="row">
<div class="col-md-2"> Status Change Date </div>
<div class="col-md-2"> 
<?= $form->field($model, 'status_change_date')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',			
        ])->label(false); ?> 
		
		</div>
		</div>
 <?= Html::submitButton('Transfer', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?>
<?php ActiveForm::end(); ?>
	
</div>