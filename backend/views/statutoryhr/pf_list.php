<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PfListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo Yii::$app->getRequest()->getQueryParam('month');
$this->title = 'PF Lists '.$searchModel->list_no;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pf-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
			[
               'attribute' => 'empid',
               'value' => 'employee.empcode',
            ],
            'gross',
            'epf_wages',
            'eps_wages',
           'edli_wages',
            'epf_contri_remitted',
           'eps_contri_remitted',
            'epf_eps_diff_remitted',
            'ncp_days',
            //'refund_of_advance',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>