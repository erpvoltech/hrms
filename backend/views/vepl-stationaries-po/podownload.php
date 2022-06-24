<?php
error_reporting(0);
use yii\helpers\Html;
use Mpdf\Mpdf;
use app\models\VeplStationaries;
use app\models\VeplStationariesPo;
use app\models\VeplStationariesPoSub;
use app\models\VeplSupplier;
use common\models\User;

$html = '
<table border="1" width="100%" style="border-collapse: collapse; font-size:10.5pt;">
<tr><td style="border: 0" width="8%"></td><td style="border: 0" width="20%"></td><td style="border: 0" width="25%"></td><td style="border: 0" width="10%"></td><td style="border: 0" width="15%"></td><td style="border: 0" width="20%"></td></tr>
<tr><td colspan="6"><img src="' . \Yii::$app->homeUrl . 'img/logo.jpg" /></td></tr>
<tr><td colspan="6" align="center" style="font-weight: bold;">Stationary Purchase Order</td></tr>

<tr>
<td colspan="3" style="padding:5px 0px 5px 6px"><h4>From</h4>
Voltech Engineers Private Limited<br>
No.2/429 Mount Poonamalle High Road<br>
Ayyappanthangal<br>
Chennai - 600056<br>
Phone No : 044 - 43978000</td>

<td colspan="3" style="padding:5px 0px 5px 6px; line-height: 1.6;">PO No &emsp; &ensp; &nbsp; : ' . $model->po_no . '<br>
PO Date &emsp; &nbsp; : ' . date('d.m.Y', strtotime($model->po_date)) . '<br>

Payment Terms & Conditions:<br>

30 days from the date of Certified  Invoice
</td>
</tr>

<tr>
<td colspan="3" style="padding:5px 0px 5px 6px"><h4>To</h4>
' . $model->suppliers->supplier_name . '<br>
' . $model->suppliers->supplier_address_one . '<br>
' . $model->suppliers->supplier_address_two . '<br>
' . $model->suppliers->supplier_address_three . '<br>    
' . $model->suppliers->supplier_contact_no . '  </td>
<td colspan="3" style="padding:5px 0px 5px 6px; line-height: 1.6;">Last Purchase<br>
Date : ' . date('d.m.Y', strtotime($model->last_purchase_date)) . '
</td>    
</tr>
<tr>
<td style="text-align: center;"> Sl.No </td> <td style="text-align: center;" colspan="2"> Description </td> <td style="text-align: right;"> Qty </td> <td style="text-align: right;"> Rate </td> <td style="text-align: right;">Amount</td>        
</tr>';
$i = 1;
foreach ($stationaryItem as $grnModel) {
    $itemName = VeplStationaries::find()->where(['id' => $grnModel->po_item_id])->one();
    $html .='<tr> <td>'.$i.'</td> <td colspan="2" >' . $itemName->item_name . '</td> <td  style="text-align: right;">' . $grnModel->po_qty . '</td> <td style="text-align: right;">' . number_format($grnModel->po_rate, 2, '.', '') . '</td> <td style="text-align: right;">' . number_format($grnModel->po_amount, 2, '.', '') . '</td> </tr>';

    $i++;
}
$html .='<tr><td style="text-align: right; padding-right: 5px;" colspan="5"> Total Amount </td><td  style="text-align: right;">' . number_format($model->po_total_amount, 2, '.', '') . '</td></tr>	
<tr><td style="text-align: right; padding-right: 5px;" colspan="5">CGST('.$model->po_cgst.')%</td><td  style="text-align: right;">' . number_format(($model->po_total_amount * $model->po_cgst) / 100, 2, '.', '') . '</td></tr>
<tr><td style="text-align: right; padding-right: 5px;" colspan="5">SGST('.$model->po_sgst.')%</td><td  style="text-align: right;">' . number_format(($model->po_total_amount * $model->po_sgst) / 100, 2, '.', '') . '</td></tr>
<tr><td style="text-align: right; padding-right: 5px;" colspan="5"> Net Amount </td><td  style="text-align: right;">' . number_format($model->po_net_amount, 2, '.', '') . '</td></tr>';
$user1 = User::find()->where(['id' => $model->po_prepared_by])->one();
$user = User::find()->where(['id' => $model->po_approved_by])->one();
$html .='<tr> <td colspan="3"> Prepared by <br> <img src="' . \Yii::$app->homeUrl . 'img/prisign.png" /> <br> S.Priscilla <br> Sr. Officer – Admin </td> <td style="text-align: right;" colspan="3"> Approved by <br> <img src="' . \Yii::$app->homeUrl . 'img/KD-sign1.png" /> <br> K.Dhavamani HR & QHSE | VEPL </tr>
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
