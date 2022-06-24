<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Emp Salarystructures';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
  
  
</style>

<div class="emp-salarystructure-index">
 <div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;">Employee Salary structures</div>
        <div class="panel-body"> 
    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <= Html::a('Create Emp Salarystructure', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            'attribute'=>'salarystructure', 
            'width'=>'310px', 
            'group'=>true,  // enable grouping,
            'groupedRow'=>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
            'worklevel',
            'grade',
            [
                'attribute' => 'basic',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'hra',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'other_allowance',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'gross',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'daperday',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'dapermonth',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'payableallowance',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            [
                'attribute' => 'netsalary',
                'contentOptions' => [ 'style' => 'text-align: right;' ],
            ],
            //'basic',
            //'hra',
            //'splallowance',
            //'gross',
            //'daperday',
            //'dapermonth',
            //'payableallowance',
            //'netsalary',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div></div>
