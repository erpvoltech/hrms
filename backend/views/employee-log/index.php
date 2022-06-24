<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user',
            'updatedate',
            'designation_from',
            'designation_to',
            //'attendance_from',
            //'attendance_to',
            //'esi_from',
            //'esi_to',
            //'pf_from',
            //'pf_to',
            //'pf_ restrict_from',
            //'pf_ restrict_to',
            //'pli_from',
            //'pli_to',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
