<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Unit;
use common\models\Division;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\AttendanceAccessRule;

$Attendance = ArrayHelper::map(User::find()->all(), 'id', 'username');
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$this->title ='Create Authentication';


 $dataprovider = new ActiveDataProvider([
            'query' => AttendanceAccessRule::find(),
			'pagination' => [
            'pageSize' => 100,
        ],
        ]);
		
?>
<div class="auth-assignment-attendance-access">
	<h3><?= Html::encode($this->title) ?></h3>
	<?= GridView::widget([
        'dataProvider' => $dataprovider,
        'layout'=>"{items}",
		'columns' => [
           ['class' => 'yii\grid\SerialColumn'],          
            [
               'attribute' => 'user',
               'value' => 'users.username',
            ],  
		   [
               'attribute' => 'unit',
               'value' => 'units.name',
            ],  
			[
               'attribute' => 'division',
               'value' => 'divisions.division_name',
            ],
			
		   
          /* ['class' => 'yii\grid\ActionColumn',
		   'headerOptions' => ['style' => 'width:20%'], 
		   
		   ],*/
        ],
    ]); ?>
    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
	<div class="col-sm-4">
        <?= $form->field($model, 'user')->dropDownList(
        $Attendance,
        ['prompt'=>'Select...']
        )?>
		</div>
	
	<div class="col-sm-4">
        <?= $form->field($model, 'unit')->dropDownList($unitData,['prompt'=>'Select...']) ?>
		
		</div>
	
	<div class="col-sm-4" id="division">
        <?= $form->field($model, 'division')->dropDownList($divData,['prompt'=>'Select...']) ?>
	</div>
	</div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
	   

</div><!-- project-details-attendance-access -->

<?php
$script = <<< JS
/*	$("#attendanceaccessrule-user").change(function(){
	var user_select = $('#attendanceaccessrule-user option:selected').val();

	if(user_select==1){
	$("#division").hide();
	}else{
		$("#division").show();
	}
	});
	
	
});*/
JS;
$this->registerJs($script);

?>
