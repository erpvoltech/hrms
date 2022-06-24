<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\EmpStatutorydetails;
use common\models\EmpPersonaldetails;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\base\Model;
?>

<div class="vg-insurance-agents-view">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: center;">

        </h3>
    </div>
    <?php
    $query = new Query;
    $query = EmpDetails::find()->joinWith(['employeeStatutoryDetail'])
            ->where(['IS NOT', 'emp_statutorydetails.gmc_no', NULL])
            ->andWhere(['NOT IN', 'emp_statutorydetails.gmc_no', ['']])
            ->andOnCondition(['<>', 'emp_details.status', 'Active']);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h5><i class="glyphicon glyphicon-list-alt"></i> Employee Relieved List - GMC </h5>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Policy No',
                'value' => 'employeeStatutoryDetail.gmc_no',
            ],
            'empcode',
            'empname',
            [
                'attribute' => 'designation_id',
                'value' => 'designation.designation',
            ],
            [
                'attribute' => 'division_id',
                'value' => 'division.division_name',
            ],
            [
                'attribute' => 'unit_id',
                'value' => 'units.name',
            ],
            
            ['attribute' => 'Date of Join',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'doj'
            ],
            'status',
            [
                'attribute' => 'Resignation Date',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'resignation_date',
            ],
            [
                'attribute' => 'Last Working Date',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'last_working_date',
            ],
            [
                'attribute' => 'Date of Leaving',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'dateofleaving',
            ],
        ],
    ]);
    ?>
</div>


