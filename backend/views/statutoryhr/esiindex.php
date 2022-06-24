<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use common\models\StatutoryEsi;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StatutoryHrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$query = StatutoryEsi::find()
        ->orderBy(['month' => SORT_ASC]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
        ]);

$this->title = 'Statutory ESI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statutory-hr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php /*
    Modal::begin([
        'header' => '<h4>Update Model</h4>',
        'id' => 'update-modal',
        'size' => 'modal-lg'
    ]);

    echo "<div id='updateModalContent'></div>";

    Modal::end(); */
    ?>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'month',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->month, "MM-yyyy");
                },
            ],
            [
                'attribute' => 'esi_list_no',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('List ' . $model->esi_list_no, ['esilist?EsiListSearch%5Besi_list_id%5D=' . $model->id . '&month=' . $model->month]);
                },
            ],
            [
                'header' => 'Download',
                'value' => function($data) {
                    return Html::a('.txt', ['loadesidata', 'id' => $data->id], ['id' => 'loadesidata']);
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{esi-challan-all}' . '&emsp;&emsp;' . '{esi-list-delete}',
                'buttons' => [
                    'esi-challan-all' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-eye-open
							"></span>', $url);
                    },
                    'esi-list-delete' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-trash
							"></span>', $url, [
                                    'title' => Yii::t('app', 'EsiListDelete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'), 'data-method' => 'post']);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
    <?php
    $script = <<<JS

$('#TrrnpopupModal').click(function(event){
	 event.preventDefault();
     $('#update-modal').modal('show').find('#updateModalContent').load($(this).attr('value'));
	});

});
JS;
    $this->registerJs($script);
    ?>
