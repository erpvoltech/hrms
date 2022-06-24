<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$model->uid = $_GET['uid'];
$model->did = $_GET['did'];
?>
<div class="project-details-search">

     <?php $form = ActiveForm::begin([
        'action' => ['attendance-view'],
        'method' => 'get',
		'layout' => 'horizontal'
    ]); ?>
	<div class="row">
	<div class="col-lg-4">
		
		<?= $form->field($model, 'attdate')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
		<?= $form->field($model, 'uid')->hiddenInput()->label(false)?>
		<?= $form->field($model, 'did')->hiddenInput()->label(false)?>
	</div>
	 <div class=" col-lg-1"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
     
	</div>
   
    <?php ActiveForm::end(); ?>

</div>