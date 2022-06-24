<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
//error_reporting(0);
ini_set('memory_limit', '-1');
?>

<?php echo $this->render('_componentsearch', ['model' => $searchModel]); ?>  
<br></br></br></br>
<div class="emp-salary-index">


<?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'empid',
            'value' => 'employee.empcode',
        ],
        'employee.empname',
		 [
            'attribute' => 'Dob',
            'value' => 'employeePersonalDetail.dob',
        ],
		
        'designations.designation',
        [
            'attribute' => 'unit',
            'value' => 'employee.units.name',
        ],
          [
            'attribute' => 'division',
            'value' => 'employee.division.division_name',
        ],
        [
            'attribute' => 'department',
            'value' => 'employee.department.name',
        ],
		[
            'attribute' => 'Doj',
            'value' => 'employee.doj',
        ],
        [
            'header' => 'Month',
            'value' => 'month',
            'format' => ['date', 'php: M Y']
        ],
		'paiddays',
        'basic',
        'hra',        
        [
            'header' => 'DA',
            'value' => 'dearness_allowance',
        ],
		'conveyance_allowance',       
        'over_time',
        'arrear',
		'advance_arrear_tes',
		'lta_earning',
		'medical_earning',
        'guaranted_benefit',
		'holiday_pay',
		'washing_allowance',		
        'dust_allowance',
        'performance_pay',
		'misc',
        'other_allowance',
		'total_earning',
        'pf',
        'insurance',
        'professional_tax',
        'esi',
		'caution_deposit',
        'advance',
        'tes',
		'mobile',
		'loan',
		'rent',
		'tds',
		'lwf',
        'other_deduction',
		'total_deduction',
		'net_amount',
		'pf_employer_contribution',
		'esi_employer_contribution',
		'pli_employer_contribution',
		'lta_employer_contribution',
		'med_employer_contribution',
		'earned_ctc',      
    ];
?>
 
<?=

GridView::widget([
    'dataProvider' => $dataProvider,
	'toolbar' => [
           ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
	'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_CSV => false,
    ],
    'dropdownOptions' => [
        'label' => 'Export',
        'class' => 'btn btn-secondary'
    ],
	]),
       ],
       'panel' => [
	       'before'=>'<i>* Default Content displayed Current Financial Year Only, Otherwise Change Month in Search</i>',
           'type' => 'info',
           'heading' => '<h3 class="panel-title"> Component Based Result </h3>',
       ],
	 'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'empid',
            'value' => 'employee.empcode',
        ],
        'employee.empname',
		 [
            'attribute' => 'Dob',
            'value' => 'employeePersonalDetail.dob',
        ],
        'designations.designation',
        [
            'attribute' => 'unit',
            'value' => 'employee.units.name',
        ],
        [
            'attribute' => 'department',
            'value' => 'employee.department.name',
        ],
		[
            'attribute' => 'Doj',
            'value' => 'employee.doj',
        ],
        [
            'header' => 'Month',
            'value' => 'month',
            'format' => ['date', 'php: M Y']
        ],
		'paiddays',
        'basic',
        'hra',        
        [
            'header' => 'DA',
            'value' => 'dearness_allowance',
        ],
		'conveyance_allowance',       
        'over_time',
        'arrear',
		'advance_arrear_tes',
		'lta_earning',
		'medical_earning',
        'guaranted_benefit',
		'holiday_pay',
		'washing_allowance',		
        'dust_allowance',
        'performance_pay',
		'misc',
        'other_allowance',
		'total_earning',
        'pf',
        'insurance',
        'professional_tax',
        'esi',
		'caution_deposit',
        'advance',
        'tes',
		'mobile',
		'loan',
		'rent',
		'tds',
		'lwf',
        'other_deduction',
		'total_deduction',
		'net_amount',
		'pf_employer_contribution',
		'esi_employer_contribution',
		'pli_employer_contribution',
		'lta_employer_contribution',
		'med_employer_contribution',
		'earned_ctc',       
    ],
]);
?>
</div>
