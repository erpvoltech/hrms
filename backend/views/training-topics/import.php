<?php 
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
?>
<h1>Import Data</h1>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>

<?= $form->field($model,'file')->fileInput() ?>

<?= Html::submitButton('Import',['class'=>'btn btn-primary']);?>

<?php ActiveForm::end();?>