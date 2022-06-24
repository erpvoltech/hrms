<?php

use yii\helpers\Html;
use Mpdf\Mpdf;
use app\models\VgPolicyClaim;

$html = '
<table border="1" width="100%" style="border-collapse: collapse; font-size:10.5pt;">
<tr><td style="border: 0" width="8%"></td><td style="border: 0" width="20%"></td><td style="border: 0" width="25%"></td><td style="border: 0" width="10%"></td><td style="border: 0" width="15%"></td><td style="border: 0" width="20%"></td></tr>
<tr><td colspan="6"><img src="' . \Yii::$app->homeUrl . 'img/logo.jpg" /></td></tr>
<tr><td colspan="6" align="center" style="font-weight: bold;">Policy Claim Form</td></tr>

<tr>
<td colspan="6" style="padding:5px 0px 5px 6px; text-align: center;">
Voltech Engineers Private Limited<br>
No.2/429 Mount Poonamalle High Road<br>
Ayyappanthangal<br>
Chennai - 600056<br>
Phone No : 044 - 43978000</td>
</td>
</tr>';
    
    $html .='<tr> <td colspan="3" height="30">Insurance Type</td> <td colspan="3"  height="30">' . $model->insurance_type . '</td> </tr>';
     if($model->insurance_type == 'GPA' || $model->insurance_type == 'GMC' || $model->insurance_type == 'WC') { 
        $html .='<tr> <td colspan="3"  height="30">Employee Name/Code</td> <td colspan="3"  height="30">'. $model->employee_name . '/' . $model->employee_code .'</td> </tr>';
    }
    $html .='<tr> <td colspan="3" height="30">Policy No</td> <td colspan="3" height="30">' . $model->policy_no . '</td> </tr>
            <tr> <td colspan="3" height="30">Policy Serial No</td> <td colspan="3" height="30">' . $model->policy_serial_no . '</td> </tr>
            <tr> <td colspan="3" height="30">Contact Person</td> <td colspan="3" height="30">' . $model->contact_person . '</td> </tr>
            <tr> <td colspan="3" height="30">Contact No</td> <td colspan="3" height="30">' . $model->contact_no . '</td> </tr>
            <tr> <td colspan="3" height="30">Nature of Loss/Damage/Accident</td> <td colspan="3" height="30">' . $model->nature_of_accident . '</td> </tr>
            <tr> <td colspan="3" height="30">Loss Type</td> <td colspan="3" height="30">' . $model->loss_type . '</td> </tr> 
            <tr> <td colspan="3" height="30">Details of Damage/Theft/Injury</td> <td colspan="3" height="30">' . $model->injury_detail . '</td> </tr>
            <tr> <td colspan="3" height="30">Place of Accident/Loss</td> <td colspan="3" height="30">' . $model->accident_place_address . '</td> </tr>
            <tr> <td colspan="3" height="30">Date and Time of Loss/Accident</td> <td colspan="3" height="30">' . $model->accident_time . '</td> </tr>
            <tr> <td colspan="3" height="30">Des.of Accident/Loss</td> <td colspan="3" height="30">' . $model->accident_notes . '</td> </tr>    
            <tr> <td colspan="3" height="30">Des.of Settlement</td> <td colspan="3" height="30">' . $model->settlement_notes . '</td> </tr>
            <tr> <td colspan="3" height="30">Settlement Amount</td> <td colspan="3" height="30">' . $model->settlement_amount . '</td> </tr>
            <tr> <td colspan="3" height="30">Claim Estimate</td> <td colspan="3" height="30">' . $model->claim_estimate . '</td> </tr>
            <tr> <td colspan="3" height="30">Claim Status</td> <td colspan="3" height="30">' . $model->claim_status . '</td> </tr>        
            <tr> <td style="padding: 5px 0px 70px 600px;" colspan="6"> Signature <br> </tr>
                
</table>';


//$html .= "<pagebreak />";
//}
$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
//ini_set("pcre.backtrack_limit", "5000000");
$mpdf->WriteHTML($html); // Separate Paragraphs defined by font
$mpdf->Output();
exit;
/* <div style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;">Employer Contribution</div> */
?>
