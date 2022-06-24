<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmpSalarystructure */

$this->title = $model->worklevel;
$this->params['breadcrumbs'][] = ['label' => 'Emp Salarystructures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table,tr,th,td{
      
        border: #ddd solid 1px;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
    }
    th{
        background-color:#f5f5f5;
      
    }
   

</style>    
<div class="emp-salarystructure-view">
<div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;"><?= Html::encode($this->title) ?></div>
        <div class="panel-body"> 

          <br>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary']) ?>
        <!--<= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <!--<= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'worklevel',
            'grade',
            'basic',
            'hra',
            'splallowance',
            'gross',
            'daperday',
            'dapermonth',
            'payableallowance',
            'netsalary',
        ],
    ]) ?>-->
    <br>
    <table >
        <thead style="background-color:#ddd">
        <th>Work Level</th>
        <th>Grade</th>
        <th>Basic</th>
        <th>HRA</th>
        <th>Spl Allowance</th>
        <th>Gross</th>
        <th>DA / Day</th>
        <th>DA / Month</th>
        <th>Payable Allowance</th>
        <th>Net Salary</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $model->worklevel ?></td>
                <td><?= $model->grade ?></td>
                <td style="text-align: right"><?= $model->basic ?></td>
                <td style="text-align: right"><?= $model->hra ?></td>
                <td style="text-align: right"><?= $model->other_allowance?></td>
                <td style="text-align: right"><?= $model->gross ?></td>
                <td style="text-align: right"><?= $model->daperday ?></td>
                <td style="text-align: right"><?= $model->dapermonth ?></td>
                <td style="text-align: right"><?= $model->payableallowance ?></td>
                <td style="text-align: right"><?= $model->netsalary ?></td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
</div>
</div>
