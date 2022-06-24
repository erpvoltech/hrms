<?php
ob_start();

use common\models\EsiList;
use common\models\EmpStatutorydetails;
use common\models\EmpDetails;

$ESIList = EsiList::find()->where(['esi_list_id' => $model->id])->all();
$m = date("m", strtotime($model->month));
$y = date("Y", strtotime($model->month));

$filename = 'ESIList' . $model->esi_list_no . '(' . $m . '-' . $y . ')' . '.txt';
$handle = fopen($filename, "w");
$text = array();
foreach ($ESIList as $data) {
    $EMP = EmpDetails::find()->where(['id' => $data->empid])->one();
    $ESINO = EmpStatutorydetails::find()->where(['empid' => $data->empid])->one();

    fwrite($handle, $ESINO->esino . '#~#' . $EMP->empname . '#~#' . $data->gross . '#~#' . $data->esi_employee_contribution . '#~#' . $data->esi_employer_contribution . "\r\n");
}

fclose($handle);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($filename));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
readfile($filename);
unlink($filename);
exit;
?>









?>