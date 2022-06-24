<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\Unit;
use common\models\Division;
use common\models\UnitGroup;
use app\models\AttendanceSearch;
error_reporting(0);
$this->title = 'Attendance Month Report';
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="attendance-report">
	
<?php
if (Yii::$app->getRequest()->getQueryParam('date'))
   $month = Yii::$app->getRequest()->getQueryParam('date');
else
   $month = '';  
print_r($month);
   
/*if (Yii::$app->getRequest()->getQueryParam('group')) {
   $group = Yii::$app->getRequest()->getQueryParam('group');
   $groupdata = Yii::$app->getRequest()->getQueryParam('group');
} else {  
   $group ='';
   $groupdata ='';
}

if (Yii::$app->getRequest()->getQueryParam('unit')) {
   $unit = Yii::$app->getRequest()->getQueryParam('unit');
   $unitdata = Yii::$app->getRequest()->getQueryParam('unit');
} else {  
   $unit ='';
   $unitdata ='';
}*/
   
   $model = new AttendanceSearch();

 echo $this->render('_attendancesearch', ['model' => $model]);
   ?>
   <div style="overflow-x:auto;">
 <?php  


?>
</div>
</div>
<br>
 <!-- <?= Html::a('Export', ['statementexport?group='.serialize($group).'&month='.$month.'&unit='.serialize($unitdata)], ['class' => 'btn btn-md btn-success']) ?> -->


<?php
$script = <<< JS
$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "EPF Report",
					filename: "epfreport",
					fileext: ".xls",					
	});
});
JS;
$this->registerJs($script);

?>