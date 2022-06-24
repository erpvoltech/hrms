<?php
ob_start();
use common\models\PfList;
use common\models\StatutoryRates;
use common\models\EmpDetails;


$pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one(); 

$Emp = EmpDetails::find()->one();


$PFList = PfList::find()->where(['list_id' => $model->id])->all();
$count = PfList::find()->where(['list_id' => $model->id])->count();
$epf_ac01 = PfList::find()->where(['list_id' => $model->id])->sum('epf_contri_remitted');
$erpf_ac10 = PfList::find()->where(['list_id' => $model->id])->sum('eps_contri_remitted');
$erpf_ac01 = PfList::find()->where(['list_id' => $model->id])->sum('epf_eps_diff_remitted');
$epf_wages = PfList::find()->where(['list_id' => $model->id])->sum('epf_wages');
$eps_wages = PfList::find()->where(['list_id' => $model->id])->sum('eps_wages');
$admin_ac02 = round(PfList::find()->where(['list_id' => $model->id])->sum('epf_wages') * ($pf_esi_rates->epf_ac_2_er / 100));
$admin_ac21 = round(PfList::find()->where(['list_id' => $model->id])->sum('epf_wages') * ($pf_esi_rates->epf_ac_21_er / 100));
$total = $erpf_ac01+$erpf_ac10+$admin_ac21 + $admin_ac02 + $epf_ac01;
?>
<div class="row">
	<div class="col-md-12" style="text-align:center">
	<h2>COMBINED CHALLAN OF A/C NO. 01,02,10,21&22 </h2>
	</div>
</div><br><b>
<div class="row">	
	<div class="col-md-4" >
		TRRN : <?=$model->trrn_no?>
	</div>
	
	<div class="col-md-2" >
		Month of <?=Yii::$app->formatter->asDate($model->month, "MMM yyyy")?>
	</div>
	<div class="col-md-2" >
		List :<?=$model->list_no?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" >
		 
	</div>
	<div class="col-md-2" >
		EPF
	</div>
	<div class="col-md-2" >
		EPS
	</div>
	<div class="col-md-2" >
		EDLI
	</div>
</div></b>
<div class="row">
	<div class="col-md-4" >
		Total Subscribers : 
	</div>
	<div class="col-md-2" >
		<?=$count?>
	</div>
	<div class="col-md-2" >
		<?=$count?>
	</div>
	<div class="col-md-2" >
		<?=$count?>
	</div>
</div>

<div class="row">
	<div class="col-md-4" >
		Total Wages : 
	</div>
	<div class="col-md-2" >
		<?=$epf_wages?>
	</div>
	<div class="col-md-2" >
		<?=$eps_wages?>
	</div>
	<div class="col-md-2" >
		<?=$eps_wages?>
	</div>
</div>

<br>
<table>
	<tr><th>SL.</th><th>PARTICULARS</th><th>A/C.01</th><th>A/C.02</th><th>A/C.10</th><th>A/C.21</th><th>A/C.22</th><th>TOTAL</th></tr>
	<tr><td>1</td><td>Administration Charges</td><td>0</td><td><?=$admin_ac02 ?></td><td>0</td><td>0</td><td>0</td><td><?=$Emp->moneyFormatIndia($admin_ac02) ?></td></tr>
	<tr><td>2</td><td>Employer's Share Of</td><td><?=$erpf_ac01?></td><td>0</td><td><?=$erpf_ac10?></td><td><?=$admin_ac21 ?></td><td>0</td><td><?=$Emp->moneyFormatIndia(($erpf_ac01+$erpf_ac10+$admin_ac21))?></td></tr>
	<tr><td>3</td><td>Employee's Share Of</td><td><?=$epf_ac01?></td><td>0</td><td>0</td><td>0</td><td>0</td><td><?=$Emp->moneyFormatIndia($epf_ac01)?></td></tr>
	<tr><td colspan="7">Grand Total : <?= $Emp->getIndianCurrency($total) .' Only' ?></td><td><?=$Emp->moneyFormatIndia($total)?></td></tr>
</table>
<br> <br><b>
<div class="row">
	<div class="col-md-6" >
		 Total remittance by Employer
	</div>
	<div class="col-md-4" >
		<?=$Emp->moneyFormatIndia($total)?>
	</div>	
</div>
<div class="row">
	<div class="col-md-6" >
		 Total Amount of uploaded ECR
	</div>
	<div class="col-md-4" >
		<?=$Emp->moneyFormatIndia($total)?>
	</div>	
</div>
</b>