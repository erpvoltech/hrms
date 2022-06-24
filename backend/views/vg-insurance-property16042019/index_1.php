<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsurancePropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Insurance Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-property-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Insurance Property', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'mother_id',
            'property_type',
            'insurance_no',
            'property_name',
            'property_no',
            'property_value',
            //'sum_insured',
            //'premium_paid',
            //'valid_from',
            //'valid_to',
            //'location',
            //'user',
            //'user_division',
            //'equipment_service',
            //'icn_id',
            //'insurance_agent_id',
            //'remarks',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
