<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Salary Editor';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
   .glyphicon {
      padding-right:10px;
   }
</style>
<div class="emp-details-index">

   <h3>Salary Generate</h3>


   <?php echo $this->render('_empsearch', ['model' => $searchModel]); ?>

   <?php Pjax::begin(); ?>
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'empcode',
           'empname',
           [
               'attribute' => 'designation_id',
               'value' => 'designation.designation',
           ],
           'remuneration.salary_structure',
           'remuneration.work_level',
           'remuneration.grade',
           [
               'attribute' => 'unit_id',
               'value' => 'units.name',
           ],
           [
               'attribute' => 'department_id',
               'value' => 'department.name',
           ],
           [
               'class' => 'yii\grid\ActionColumn',
               'template' => '{generatesalary} ',
               'buttons' => [
                   'generatesalary' => function ($url, $model) {
                      return Html::a(
                                      '<span><i class="fa fa-inr" style="font-size:18px; color:#337ab7;"></i>  </span>', ['emp-salary/create', 'id' => $model->id], [
                                  'title' => 'Salary Generate',
                                  'data-pjax' => '0',
                                      ]
                      );
                   },
                       ],
                   ],
               ],
           ]);
           ?>
           <?php Pjax::end(); ?></div>
