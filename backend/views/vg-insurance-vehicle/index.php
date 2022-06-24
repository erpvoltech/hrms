<?php
error_reporting(0);
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\base\Model;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VgInsuranceVehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insurance-Vehicles';
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
<div class="vg-insurance-vehicle-index">
	<?php if(Yii::$app->user->identity->username != 'COC'){ ?>
    <div class="row">  
        <div class="pull-left" style="padding:30px 5px 5px 10px;">
            <?php echo Html::a('Create Insurance-Vehicle', ['create'], ['class' => ' btn-sm btn-success']) ?>
        </div>
    </div>
	<?php } ?>
    <br><br></br>
    <?php Pjax::begin(); ?> 

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false
        ],
        'panel' => [
		'type' => 'info',
            'heading' => '<h4 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Vehicle Policy List </h4>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'icn_id',
            // 'insurance_agent_id',
            /* [
              'attribute' => 'icn_id',
              'value' => 'company.company_name',
              ],
              [
              'attribute' => 'insurance_agent_id',
              'value' => 'agent.agent_name',
              ], */
            'insurance_no',
            //'property_type',
            'property_name',
            'vehicle_type',
            'property_no',
            'location',
            ['attribute' => 'sum_insured',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            ['attribute' => 'premium_paid',
                'contentOptions' => ['style' => 'text-align: right;'],
                'format' => ['decimal', 2, '.', '']
            ],
            //'property_value',
            //'valid_from',
            //'valid_to',
            'user',
			[
                'attribute' => 'valid_to',
                'format' => ['date', 'php:d-m-Y']
            ],
            //'user_division',
            //'insured_to',
            //'remarks',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {file}',
				'buttons' => [
                    'file' => function ($model, $key) {

                        return Html::a(
                                        '<span class="glyphicon glyphicon-list-alt"></span>', ['user-files', 'id' => $key->property_no], ['target' => '_blank', 'data-pjax' => 0]);
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
