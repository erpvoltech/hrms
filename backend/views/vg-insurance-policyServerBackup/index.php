<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsurancePolicySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vg Insurance Policies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-policy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vg Insurance Policy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'policy_for',
            'policy_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
