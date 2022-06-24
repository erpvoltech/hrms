<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="vg-insurance-property-index">

    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create PIS', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>
    <?php Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'toolbar' => [
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Property Information System List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'property_type',
            'property_name',
            'property_no',
           // 'location',
            ['attribute' =>'location',
             'format' => 'raw',
                'value' => function($model) {
                    $tooltip = $model->location;
                    if (strlen($tooltip) > 20)
                        $loctxt =  substr($tooltip, 0, 30) . '...';
                    else
                        $loctxt =  $tooltip;
                    
                    return '<a title="' . $tooltip . '">' . $loctxt . '</a>';
                },
            ],
            //'user',
            //'user_division',
            //'equipment_service',
            //'remarks',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
