<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VeplStationariesIssueSubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vepl Stationaries Issue Subs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-issue-sub-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vepl Stationaries Issue Sub', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'issue_id',
            'issue_item_id',
            'issued_qty',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
