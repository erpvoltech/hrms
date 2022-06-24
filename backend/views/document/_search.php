<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
		 'layout' => 'horizontal',
    ]); ?>
	   <div class="row">    

   <div class=" col-lg-4">  <?= $form->field($model, 'type')->dropDownList([ '1'=>'Bonafide','2'=>'Relieving Letter'], ['prompt' => ' ']) ?>
	</div>      
      <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?></div>
    
    </div>

    <?php ActiveForm::end(); ?>

</div>
