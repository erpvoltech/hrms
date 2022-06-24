<?php

use app\models\VgInsurancePolicy;

$model->policy_for = $_GET['policyfor'];
$model->policy_type = $_GET['policycategory'];
$model->save();

$rows = VgInsurancePolicy::find()->all();

foreach ($rows as $row) {
    echo "<option selected value='$row->id'>$row->policy_type</option>";
}
?>
