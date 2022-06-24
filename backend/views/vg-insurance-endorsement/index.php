<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VgInsuranceEndorsementClass */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Insurance Endorsements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-endorsement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Insurance Endorsement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mother_policy_id',
            'endorsement_no',
            'start_date',
            'end_date',
            //'endorsement_premium_paid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
