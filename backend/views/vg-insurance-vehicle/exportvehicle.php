<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\VgInsuranceVehicle;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

error_reporting(0);
$model = new VgInsuranceVehicle();
//$companyData = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
//$agentData = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');
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
</style>
<br>
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?php ActiveForm::end(); ?>
</br><br><br>
<div class="row">
    <div class="col-md-5">
        <h4>Export Vehicle Policy(EVP) Data</h4>
    </div>
</div>
<div class="row" style="border: 2px solid #000; line-height: 25px;">
    <br><br>
    
    <div class="col-md-12" style="text-align:center"> Select Export Type :
        <input type="radio" name="datavalue" value="2"> Without data
        <input type="radio" name="datavalue" value="1"> With data
        <div id="selecterror" style="color:red"> </div>
        <br><br>
        <br>
        <button class="btn btn-default " type="button" id="exportvehicle" style="text-align: center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Vehicle</button> <br><br><br>
    </div>
</div>

<?php
$script = <<<JS
		   
     $("#exportvehicle").click(function() {
         
     var exporttype = $('input[name=datavalue]:checked').val();
     if(exporttype){
            var printWindow = window.open('exportvehicledata?type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
            printWindow.document.title = "Downloading";
            printWindow.addEventListener('load', function () {
            }, true);
     } else {
     $('#selecterror').html('Select Export Type');			
     }
    });

JS;
$this->registerJs($script);
?>
</div>