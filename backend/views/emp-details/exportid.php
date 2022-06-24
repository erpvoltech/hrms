<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\VgInsuranceVehicle;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

error_reporting(0);

?>

<style>
    .glyphicon {
        padding-right:10px;
    } table{
        background-color:#DFDFDF;

    }
    .btn-default {
        background-color: #fafafa;
        color: #444;
        border-color: #fafafa;
        width : 250px;
        padding:12px;
        text-align:left;
    }
	.row{
		
	margin-right: 473px;
    margin-left: 150px;
	}
</style>
<br>
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?php ActiveForm::end(); ?>
</br><br><br>
<div class="row">
    <div class="col-md-5">
        <h4>Export ID Card Details</h4>
    </div>
</div>
<div class="row" style="border: 2px solid #000; line-height: 20px;">
    <br><br>
    
    <div class="col-md-12" style="text-align:center"> 
     
       
       
        <button  class="btn-xs btn-success" type="button" id="exportidcard" style="text-align: center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            ID Card Export</button> <br><br><br>
    </div>
</div>

<?php
$script = <<<JS
		   
     $("#exportidcard").click(function() {
          
     var exporttype = $('input[name=datavalue]:checked').val();
 
            var printWindow = window.open('exportidcarddata', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
            printWindow.document.title = "Downloading";
            printWindow.addEventListener('load', function () {
            }, true);
   
    });

JS;
$this->registerJs($script);
?>
</div>