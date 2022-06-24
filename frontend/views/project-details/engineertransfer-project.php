<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\EmpDetails;
use common\models\Division;
use common\models\Unit;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$empid = $_GET['id'];
$Emp = EmpDetails::find()->where(['id'=>$empid])->one();
$div = Division::find()->where(['id'=>$Emp->division_id])->one();
$uin = Unit::find()->where(['id'=>$Emp->unit_id])->one();
$unit = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>
<div class="project-details-employee-transfer">

<?php $form = ActiveForm::begin(['layout' => 'horizontal']);?>
<br>
<div class="row">
<div class="col-md-2"> Name </div> 
<div class="col-md-2"> <?=$Emp->empname?> </div>
<div class="col-md-2"> Unit </div>
<div class="col-md-2"> <?=$uin->name?>
<?= $form->field($model,'unit_from')->hiddeninput(['value' => $Emp->unit_id])->label(false); ?>
</div>
<div class="col-md-2"> Division/ Region </div>
<div class="col-md-2"> <?=$div->division_name?> 
<?= $form->field($model,'division_from')->hiddeninput(['value' => $Emp->division_id])->label(false); ?>
</div></div>
<br>
<div class="row">
<div class="col-md-2"> Transfer To </div>
<div class="col-md-3">  <?= $form->field($model, 'unit_to')->dropDownList(
        $unit,
        ['prompt'=>'']
        )->label(false);?>

</div>
<div class="col-md-3">  
		<?php
            echo $form->field($model, 'division_to')->widget(DepDrop::classname(), [
                'options' => ['division_to' => 'id'],
                'pluginOptions' => [
                    'depends' => ['engineertransferproject-unit_to'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['depend'])
                ]
            ]);
            ?>       
		

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