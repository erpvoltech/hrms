<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'User Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #signupform-role{
    font-size: 12px;
    height: 30px;
}
    </style>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'role')->dropDownList(['hr'=>'HR','project admin'=>'project admin','unit admin'=>'unit admin','unit users'=>'unit user','finance approval1'=>'finance approval1','finance approval2'=>'finance approval2','hr'=>'hr'],['prompt'=>'']);?>

                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
