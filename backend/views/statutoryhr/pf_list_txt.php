<?php
ob_start();
use common\models\PfList;
use common\models\EmpStatutorydetails;
use common\models\EmpDetails;

$PFList = PfList::find()->where(['list_id' => $model->id])->all();
$m = date("m", strtotime($model->month));
$y = date("Y", strtotime($model->month));
			
$filename ='PFlis'.$model->list_no.'('.$m.'-'.$y.')'.'.txt';
 $handle = fopen($filename, "w");
 $text = array();
foreach ($PFList as $data)
{
	 $EMP = EmpDetails::find()->where(['id'=>$data->empid])->one();
	 $UAN = EmpStatutorydetails::find()->where(['empid' =>$data->empid])->one();
	 
     fwrite($handle, $UAN->epfuanno .'#~#'. $EMP->empname.'#~#'.$data->gross.'#~#'.$data->epf_wages.'#~#'.$data->eps_wages.'#~#'.$data->edli_wages.'#~#'.$data->epf_contri_remitted.'#~#'.$data->eps_contri_remitted.'#~#'.$data->epf_eps_diff_remitted.'#~#'.$data->ncp_days.'#~#'.$data->refund_of_advance. "\r\n");
}

    fclose($handle);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($filename));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
	unlink($filename);
    exit;
?>









?>