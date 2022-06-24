<?php

use app\models\VgInsuranceCompany;

$model->company_name = $_GET['name'];
$model->save();

$rows = VgInsuranceCompany::find()->all();

foreach ($rows as $row) {
    echo "<option selected value='$row->id'>$row->company_name</option>";
}
?>
