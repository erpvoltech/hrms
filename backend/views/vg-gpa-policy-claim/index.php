<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgGpaPolicyClaimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Gpa Policy Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gpa-policy-claim-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Gpa Policy Claim', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee_id',
            'policy_serial_no',
            'contact_person',
            'contact_no',
            //'nature_of_accident',
            //'injury_detail',
            //'accident_place_address',
            //'accident_time',
            //'accident_notes',
            //'total_bill_amount',
            //'claim_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
