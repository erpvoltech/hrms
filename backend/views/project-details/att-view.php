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
               'attribute' => 'project_emp_id',
               'value' => function ($model){
				   return $model->employee->emp->empname . ' ('.$model->employee->emp->empcode.')' ;
				   }
				],	
				'month',
				'days',
				'hours',
				'day1_in',
				'day1_out',
				'day2_in',
				'day2_out',
				'day3_in',
				'day3_out',
				'day4_in',
				'day4_out',
				'day5_in',
				'day5_out',
				'day6_in',
				'day6_out',
				'day7_in',
				'day7_out',
				'day8_in',
				'day8_out',
				'day9_in',
				'day9_out',
				'day10_in',
				'day10_out',
				'day11_in',
				'day11_out',
				'day12_in',
				'day12_out',
				'day13_in',
				'day13_out',
				'day14_in',
				'day14_out',
				'day15_in',
				'day15_out',
				'day16_in',
				'day16_out',
				'day17_in',
				'day17_out',
				'day18_in',
				'day18_out',
				'day19_in',
				'day19_out',
				'day20_in',
				'day20_out',
				'day21_in',
				'day21_out',
				'day22_in',
				'day22_out',
				'day23_in',
				'day23_out',
				'day24_in',
				'day24_out',
				'day25_in',
				'day25_out',
				'day26_in',
				'day26_out',
				'day27_in',
				'day27_out',
				'day28_in',
				'day28_out',
				'day29_in',
				'day29_out',
				'day30_in',
				'day30_out',
				'day31_in',
				'day31_out',
				
				[
			
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {edit} ',
                'buttons' => [                    
					  'edit' => function ($model,$key) {
                     return Html::a('edit', ['att-edit', 'id' => $key->id], [ 'class' => 'btn-xs btn-primary','style'=> 'color: #fff;padding:5px 20px']);                  
                     },
                ],
            ],
        ],
    ]); ?>
</div>
