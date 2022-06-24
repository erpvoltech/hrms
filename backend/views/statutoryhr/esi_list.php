<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PfListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo Yii::$app->getRequest()->getQueryParam('month');
$this->title = 'ESI Lists ' . $searchModel->esi_list_no;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pf-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'empid',
                'value' => 'employee.empcode',
            ],
            'gross',
            'esi_employee_contribution',
            'esi_employer_contribution',
        //'refund_of_advance',
        // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>