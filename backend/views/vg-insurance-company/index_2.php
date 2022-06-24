<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Insurance Companies';
$this->params['breadcrumbs'][] = 'Insurance Service Provider';
?>
<div class="vg-insurance-company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create ISP', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'company_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
