<?php
/*namespace app\components;
use yii\widgets;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;*/

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Division */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resetpassword-form">   	
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php  
    echo $form->field($model, 'password');
    echo $form->field($model, 'changepassword');
    echo $form->field($model, 'reenterpassword');
    ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
  
</div>
	
	
</div>
