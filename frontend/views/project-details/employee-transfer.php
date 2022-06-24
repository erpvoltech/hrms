<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\EmpDetails;
use common\models\Division;

$empid = $_GET['eid'];
$Emp = EmpDetails::find()->where(['id'=>$empid])->one();
$div = Division::find()->where(['id'=>$Emp->division_id])->one();
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>
<div class="project-details-employee-transfer">

<?php $form = ActiveForm::begin(['layout' => 'horizontal']);?>
<br>
<div class="row">
<div class="col-md-2"> Name </div> 
<div class="col-md-2"> <?=$Emp->empname?> </div>
<div class="col-md-2"> Division/ Region </div>
<div class="col-md-2"> <?=$div->division_name?> 
<?= $form->field($model,'division_from')->hiddeninput(['value' => $Emp->division_id])->label(false); ?>
</div></div>
<br>
<div class="row">
<div class="col-md-2"> Transfer To </div>
<div class="col-md-2">  <?= $form->field($model, 'division_to')->dropDownList(
        $division,
        ['prompt'=>'']
        )->label(false);?>

</div></div><br>
<div class="row">
<div class="col-md-2"> Transfer Date </div>
<div class="col-md-2"> 
<?= $form->field($model, 'transfer_date')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',			
        ])->label(false); ?> 
		
		</div>
		</div>
 <?= Html::submitButton('Transfer', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?>
<?php ActiveForm::end(); ?>
	
</div>