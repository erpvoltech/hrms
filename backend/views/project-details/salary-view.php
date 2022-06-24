<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\ProjectDetails;
use common\models\CustomerContact;

 $this->title = 'Project Salary';

 $dataProvider = new ActiveDataProvider([
            'query' => $model,
 ]);

?>

		
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider, 
		'toolbar' =>  [
       
        '{export}',
        '{toggleData}',
    ],
	'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Salary View - IR</h3>',
       ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
				[
			   'header' => 'Code',
               'attribute' => 'project_id',
               'value' => 'project.project_code',
				],
				'month',
				[
			   'header' => 'Employee',
               'attribute' => 'emp_id',
               'value' => function ($model){
				   return $model->employee->emp->empname . ' ('.$model->employee->emp->empcode.')' ;
				   }
				],
				
				'wages',
				'days',
				'overtime_hours',
				'basic_da',
				'spacial_basic',
				'overtime_payment',
				'hra',
				'canteen_allowance',
				'transport_allowance',
				'washing_allowance',
				'other_allowance',
				'total',
				'pf',
				'esi',
				'society',
				'income_tax',
				'insurance',
				'others',
				'recoveries',
				'deduction_total',
				'netpayment',
				'employer_pf',
				[
			
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {edit} ',
                'buttons' => [                    
					  'edit' => function ($model,$key) {
                     return Html::a('edit', ['sal-edit', 'id' => $key->project_id,'month' => $key->month,'emp' => $key->emp_id], [ 'class' => 'btn-xs btn-primary','style'=> 'color: #fff;padding:5px 20px']);                  
                     },
                ],
            ],
        ],
    ]); ?>
</div>
