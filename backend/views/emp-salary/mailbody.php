<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpSalary;
use common\models\EmpDetails;

$this->title = 'Mail Payslip';
$this->params['breadcrumbs'][] = $this->title;

$Salmodel = EmpSalary::findOne($_GET['id']);
$ModelEmp = EmpDetails::find()->where(['id'=>$Salmodel->empid])->one();   
if($ModelEmp->category=='HO Staff' || $ModelEmp->category=='BO Staff'){
$model->body = 'Dear '.$ModelEmp->empname.' ('.$ModelEmp->empcode.'),<br> 
Your Payslip for the Month of '.Yii::$app->formatter->asDate($Salmodel->month,"php:F Y,").' is attached with this mail for your kind perusal. <br><br>
<a href="http://hrms.voltechgroup.com/backend/web/payslip/salarypdf?id='.$Salmodel->email_hash.'"> please download your payslip by clicking here, within 30 days from the receipt of this mail.</a><br><br>
Please revert us for clarifications (if any). <br><br><br>
Regards, <br>
Nandhini K <br>
Sr.Executive - HR(Payroll) <br>
9360137254';
}else{
	
$model->body = 'Dear '.$ModelEmp->empname.' ('.$ModelEmp->empcode.'),<br> 
Your Payslip for the Month of '.Yii::$app->formatter->asDate($Salmodel->month,"php:F Y,").' is attached with this mail for your kind perusal. <br><br>
<a href="http://hrms.voltechgroup.com/backend/web/payslip/salarypdf?id='.$Salmodel->email_hash.'"> please download your payslip by clicking here, within 30 days from the receipt of this mail.</a><br><br>
Please revert us for clarifications (if any). <br><br><br>
Regards, <br>
R Gajendran <br>
Manager - HR(Payroll) <br>
9360137244';
}


?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        < * any information *>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'mail-form']); ?> 
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textarea(['rows' => 15]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-mail']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
