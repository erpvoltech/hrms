<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">
    <?php
    $form = ActiveForm::begin([
                    //'id' => 'leave-apply-form',
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => false,
                    //'options' => ['class' => 'model-form']
    ]);
    ?>
    <?= $form->field($model, 'issued_qty')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), 'index', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

