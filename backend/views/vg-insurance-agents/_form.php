<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceCompany;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;

$insCompany = VgInsuranceCompany::find()->all();
$compName = ArrayHelper::map($insCompany, 'id', 'company_name');
?>

<div class="vg-insurance-agents-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">ISP/Agents Entry Form</i></div>
        <div class="panel-body">       
            <?php
            Modal::begin([
                'header' => '<h4 style="color:#007370;text-align:center">Create Insurance Company</h4>',
                'id' => 'insurancecompany',
            ]);
            echo "<div id='CompanyContent'></div>";
            Modal::end();
            ?>
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($model, 'company_id')->dropDownList($compName, ['prompt' => 'Select...']) ?>
                </div>

                <div class="col-sm-5">
                    <?= Html::button('', ['value' => Url::to('createcompany'), 'class' => 'glyphicon glyphicon-plus-sign btn btn-default btn-sm', 'id' => 'CompanyButton', 'title' => 'Add New ISP']) ?>  
                </div> 
            </div>
       
        <div class="row">
            <div class="col-sm-5">
                <?= $form->field($model, 'agent_name')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-sm-5">
                <?= $form->field($model, 'official_contact_no')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5">
                <?= $form->field($model, 'personal_contact_no')->textInput(['maxlength' => true]) ?>
            </div>
        
            <div class="col-sm-5">
                <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6"></div>
            <div class="form-group col-lg-5">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>

<?php
$script = <<< JS

 $('#CompanyButton').click(function () {
      $('#insurancecompany').modal('show')
              .find('#CompanyContent')
              .load($(this).attr('value'));
   });

JS;
$this->registerJs($script);
?>

