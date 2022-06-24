<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\EmpDetails;
error_reporting(0);
		
$params = urlencode(serialize(Yii::$app->request->queryParams['SalarySearch']));
		
?>

<?php echo $this->render('_emailsearch', ['model' => $searchModel]); ?>  
<br></br></br></br></br></br>
<div class="emp-salary-index">
<?php Pjax::begin(); ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'toolbar' => [
          Html::a('Send All', ['bulk-mail?modeldata='.$params], ['class'=>'btn btn-md btn-success'])
    ],
    'panel' => [
	 'before'=>'<i>* Default Content displayed Current Financial Year Only, Otherwise Change Month in Search</i>',
        'type' => 'info',
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Payslip</h3>',
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'empid',
            'value' => 'employee.empcode',
        ],
        'employee.empname',
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
            'header' => 'Month',
            'value' => 'month',
            'format' => ['date', 'php: M Y']
        ],
        'basic',
        'hra',        
        [
            'header' => 'DA',
            'value' => 'dearness_allowance',
        ],
		'other_allowance',
        'net_amount',
        //'over_time',
        //'arrear',
        //'guaranted_benefit',
        //'dust_allowance',
        //'performance_pay',
        //'other_allowance',
        //'pf',
        //'insurance',
        //'professional_tax',
        //'esi',
        //'advance',
        //'tes',
        //'other_deduction',
		
		[ 'label' => 'Hold Mail',
               'format' => 'raw',
               'value' => function ($model) {
			   if($model->hold == 1){
				    return Html::a('<span class="glyphicon glyphicon-lock">  </span>', ['releasemail', 'id' => $model->id]);              
				   } else {
				    return Html::a('<span class="glyphicon glyphicon-send"> </span>', ['holdmail', 'id' => $model->id]);        
				   }                  
               },
        ],
		
        [ 'label' => 'Send Mail',
               'format' => 'raw',
               'value' => function ($model) {
			   if($model->email_status == 0){
				    return Html::a('<span class="glyphicon glyphicon-envelope"> Send </span>', ['mailbody', 'id' => $model->id]);              
				   } else {
				    return Html::a('<span class="glyphicon glyphicon-envelope"> Re-send </span>', ['mailbody', 'id' => $model->id]);        
				   }                 
               },
        ],
		['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]);
?>
 <?php Pjax::end(); ?>
</div>
