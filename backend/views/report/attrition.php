<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\EmpDetails;
use common\models\Vgunit;
use common\models\UnitGroup;
use common\models\EmpSalary;
use common\models\Division;

error_reporting(0);

$modelUnit = Unit::find()->orderBy('id')->all();
$current_year = date("Y");
$current_month = date("m");

$model->month= $year;
if($model->month == $current_year){
  $check_month = $current_month;
} else {
    $check_month = 16;
} ?>
<div class="row">
  <?php $form = ActiveForm::begin(['layout'=>horizontal]); ?>
  <div class="col-md-4">
    <?= $form->field($model, 'month')->dropDownList(['2018' => '2018', '2019' => '2019','2020' => '2020','2021' => '2021'], ['prompt' =>'select ...'])->label('Select Year')?>
  </div><div class="col-md-4"><?= Html::submitButton('Go', ['class' => 'btn btn-success'])?></div>

  <?php ActiveForm::end(); ?>
</div><br>

<?php
foreach ($modelUnit as $unit){  ?>
  <table><tr><th>Month</th><th>Unit</th><th>Opening Strength</th><th>New Joining</th><th>Left</th><th>Closing Strength</th><th>Other</th><th>Attrition Value</th></tr>
    <?php
    $UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
    //  foreach ($UnitGroupModel as $groupmodel){
    for($mon =4 ;$mon < $check_month; $mon++){
          if($mon == 13){
            $month_current = 1;
            $year_current = $year + 1;
            $month_opening = 12;
            $year_opening = $year;
          } else if($mon == 14){
            $month_current = 2;
            $year_current = $year + 1;
            $month_opening = $month_current - 1;
            $year_opening = $year + 1;
          } else if($mon == 15){
            $month_current =3;
            $year_current = $year + 1;
            $month_opening = $month_current - 1;
            $year_opening = $year + 1;
          } else {
            $month_current = $mon;
            $year_current =$year;
            $month_opening = $month_current - 1;
            $year_opening = $year;
          }

          // For opening strength

          $opening_month = date ('Y-m-d', strtotime($year_opening.'-'.$month_opening.'-01'));
          $model_opening =  EmpSalary::find()->joinWith(['employee'])
          //  ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
          ->where(['month'=>$opening_month,'emp_salary.unit_id'=>$unit->id])
          ->andWhere('total_earning > 1')
          ->count();

          // New Joing $$ resigned
           $joingdate_start = date ('Y-m-d', strtotime($year_current.'-'.$month_current.'-01'));
           $joingdate_end = date("Y-m-t", strtotime($year_current.'-'.$month_current.'-01'));
          $newjoing =  EmpDetails::find()
          //  ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
          ->where(['unit_id'=>$unit->id])
          ->andWhere(['between','doj',$joingdate_start,$joingdate_end])
          ->count();

          $left =  EmpDetails::find()
          //  ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
          ->where(['unit_id'=>$unit->id])
          ->andWhere(['between','resignation_date',$joingdate_start,$joingdate_end])
          ->count();

            // For Current strength

          $month = date ('Y-m-d', strtotime($year_current.'-'.$month_current.'-01'));
          $modelSalcount =  EmpSalary::find()->joinWith(['employee'])
          //  ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
          ->where(['month'=>$month,'emp_salary.unit_id'=>$unit->id])
          ->andWhere('total_earning > 1')
          ->count();
        //   $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();$division->division_name
        $attrition_value = (($left/$modelSalcount) * 100) > 0 ? (($left/$modelSalcount) * 100) :' ';
        echo '<tr><td>'.  date("F,Y", strtotime($month)) .'</td><td>'.$unit->name.'</td><td>'.$model_opening.'</td><td>'.$newjoing.'</td><td>'.$left.'</td><td>'.$modelSalcount.'</td><td>'.(($left + $modelSalcount) - ($model_opening + $newjoing)).'</td><td>'. $attrition_value.'</td></tr>';
      }

    //  }
    ?>
  </table>
<?php  } ?>
