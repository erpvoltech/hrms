<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgInsuranceEquipment;

$policyNo = $_GET['id'];
$equipmentData = VgInsuranceEquipment::find()->where(['insurance_no' => $policyNo])->all();

$this->title = $policyNo;
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Equipments', 'url' => ['equipmentindexnew']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table{
        font-size: 11px;
    }
</style>

<div class="vg-insurance-equipment-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">Equipment Policy Data for Policy No.</font><font style="color: #cc00cc; font-weight: bold; font-style: oblique;"> <?= $policyNo ?></font>
        </div>
        <div class="panel-body" style="padding: 3px; position:relative; overflow: auto;"> 
            <div class="row">
                <div class="col-md-12">

                    <table>
                        <tr>
                            <th>Sl.No</th>
                            <th>Insurance No</th>
                            <th>Equipment Name</th>
                            <th>Serial No</th>
                            <th>Equipment Value</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
							<th>Year</th>
                            <th>Location</th>
                            <th>Insured To</th>
                            <th>User Division</th>
                            <th>Equipment Service</th>
                            <th>Remarks</th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($equipmentData as $model) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?php echo Html::a($model->insurance_no, \yii::$app->homeUrl . 'vg-insurance-equipment/update?id=' . $model->id, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold', 'title' => 'Update Policy']) . '<br>'; ?></td>
                                
                                <td><?= $model->property_name ?></td>
                                <td><?= $model->property_no ?></td>
                                <td><?= $model->property_value ?></td>
                                <td style="text-align: right;"><?= $model->sum_insured ?></td>
                                <td style="text-align: right;"><?= $model->premium_paid ?></td>
                                <td><?= date('d.m.Y', strtotime($model->valid_from)) ?></td>
                                <td><?= date('d.m.Y', strtotime($model->valid_to)) ?></td>
								<td><?php
                            if($model->financial_year != ''){
                                echo $model->financial_year;
                            }else{
                                echo '';
                            }
                            ?></td>
                                <td style="width: 50%; height: 20%;"><?= $model->location ?></td>
                                <td><?= $model->insured_to ?></td>
                                <td><?= $model->user_division ?></td>
                                <td><?= $model->equipment_service ?></td>
                                <td><?= $model->remarks ?></td>
                            </tr>
    <?php $i++;
} ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

