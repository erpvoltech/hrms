<?php
ob_start();

use common\models\EsiList;
use common\models\StatutoryRates;
use common\models\EmpDetails;

$esi_rates = StatutoryRates::find()->where(['id' => 1])->one();

$Emp = EmpDetails::find()->one();


$ESIList = EsiList::find()->where(['esi_list_id' => $model->id])->all();
$count = EsiList::find()->where(['esi_list_id' => $model->id])->count();
$esiEmployerContribution = EsiList::find()->where(['esi_list_id' => $model->id])->sum('esi_employer_contribution');
$esiEmployeeContribution = EsiList::find()->where(['esi_list_id' => $model->id])->sum('esi_employee_contribution');
//$adminEmployerContribution = round(EsiList::find()->where(['esi_list_id' => $model->id])->sum('esi_employer_contribution') * ($esi_rates->esi_er / 100));
//$adminEmployeeContribution = round(EsiList::find()->where(['esi_list_id' => $model->id])->sum('esi_employee_contribution') * ($esi_rates->esi_ee / 100));
$total = $esiEmployerContribution + $esiEmployeeContribution;
?>
<div class="row">
    <div class="col-md-12" style="text-align:center">
        <h2>COMBINED ESI CHALLAN</h2>
    </div>
</div><br><b>
    <div class="row">
        <div class="col-md-2" >
            Month of <?= Yii::$app->formatter->asDate($model->month, "MMM yyyy") ?>
        </div>
        <div class="col-md-2" >
            List :<?= $model->esi_list_no ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4" >

        </div>
        <div class="col-md-2" style="text-align: right">
            ESI EMPLOYER CONTRIBUTION
        </div>
        <div class="col-md-2" style="text-align: right">
            ESI EMPLOYEE CONTRIBUTION
        </div>
    </div></b>
<div class="row">
    <div class="col-md-4" >
        Total Subscribers :
    </div>
    <div class="col-md-2" style="text-align: right">
        <?= $count ?>
    </div>
    <div class="col-md-2" style="text-align: right">
        <?= $count ?>
    </div>

</div>

<div class="row">
    <div class="col-md-4" >
        Total Wages :
    </div>
    <div class="col-md-2" style="text-align: right">
        <?= $esiEmployerContribution ?>
    </div>
    <div class="col-md-2" style="text-align: right">
        <?= $esiEmployeeContribution ?>
    </div>
</div>

<br>
<table>
    <tr><th>Sl.No</th><th>Particulars</th><th>Employer Contribution</th><th>Employee Contribution</th><th>Total</th></tr>
    <?php /* <tr><td>1</td><td>Administration Charges</td><td style="text-align: right;"><?= $adminEmployerContribution ?></td><td style="text-align: right;"><?= $adminEmployeeContribution ?></td><td style="text-align: right;"><?= $Emp->moneyFormatIndia($adminEmployerContribution + $adminEmployeeContribution) ?></td></tr> */ ?>
    <tr><td>1</td><td>Employer's Share of</td><td style="text-align: right;"><?= $esiEmployerContribution ?></td><td></td><td style="text-align: right;"><?= $Emp->moneyFormatIndia($esiEmployerContribution) ?></td></tr>
    <tr><td>2</td><td>Employee's Share of</td><td style="text-align: right;"><?= $esiEmployeeContribution ?></td><td></td><td style="text-align: right;"><?= $Emp->moneyFormatIndia($esiEmployeeContribution) ?></td></tr>
    <tr><td colspan="4">Grand Total : <?= $Emp->getIndianCurrency($total) . ' Only' ?></td><td style="text-align: right;"><?= $Emp->moneyFormatIndia($total) ?></td></tr>
</table>
<br> <br><b>
    <div class="row">
        <div class="col-md-6" >
            Total Remittance by Employer
        </div>
        <div class="col-md-2" style="text-align: right">
            <?= $Emp->moneyFormatIndia($total) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" >
            Total Amount of uploaded ECR
        </div>
        <div class="col-md-2" style="text-align: right">
            <?= $Emp->moneyFormatIndia($total) ?>
        </div>
    </div>
</b>