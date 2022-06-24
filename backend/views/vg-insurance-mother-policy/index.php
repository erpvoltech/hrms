<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceMotherPolicySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Insurance Mother Policies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-mother-policy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Insurance Mother Policy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'policy_for_id',
            'insurance_comp_id',
            'insurance_agents_id',
            'policy_no',
            //'from_date',
            //'to_date',
            //'premium_paid',
            //'remarks',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
