<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<?php echo $this->render('_editsearch', ['model' => $searchModel]); ?> 
  </br>
   </br>
     </br>
   </br>  </br>
   </br>
<div class="emp-salary-index">
    
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       'toolbar' => [
       ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Employee Details</h3>',
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
           ['class' => 'yii\grid\ActionColumn',
               'buttons' => [
                   'update' => function($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'model' => $model, 'id' => $model->id], [
                                  'class' => '',
                      ]);
                   },
                       ]
                   ],
               ],
           ]);
           ?>
</div>
