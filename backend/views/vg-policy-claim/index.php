<?php
error_reporting(0);
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgPolicyClaimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Policy Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .glyphicon {
        padding-right:10px;
    } table{
        background-color:#DFDFDF;
    }

    /*.panel {
        margin-right: 180px;   
        }*/
</style>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="vg-policy-claim-index">
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create Policy Claim', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
    <br><br></br>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'toolbar' => [
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Policy Claim List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'policy_no',
            'insurance_type',
            //'employee_code',
            //'employee_name',
            'claim_status',
            ['attribute' => 'settlement_amount',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            ['attribute' => 'claim_estimate',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            ['label' => 'Download',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->claim_status == 'Pending') {
                        return 'Amount Yet to Settle';
                    } else {
                        return Html::a('Click Here', 'claimdownload?id=' . $model->id, ['target' => '_blank', 'data-pjax' => "0"]);
                    }
                },
            ],
            //'policy_serial_no',
            //'contact_person',
            //'contact_no',
            //'nature_of_accident',
            //'loss_type',
            //'injury_detail',
            //'accident_place_address',
            //'accident_time',
            //'accident_notes',
            //'settlement_notes',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
