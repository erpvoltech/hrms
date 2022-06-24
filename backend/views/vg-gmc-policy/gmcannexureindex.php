<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\Unit;
use common\models\EmpStatutorydetails;
use app\models\VgGmcPolicy;
use app\models\VgGmcHierarchy;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\base\Model;

error_reporting(0);
?>
<div class="vg-insurance-agents-view">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: center;">

        </h3>
    </div>
    <?php
    $query = new Query;

    $query = EmpDetails::find()->joinWith(['employeeStatutoryDetail'])
            ->where(['IS NOT', 'emp_statutorydetails.gmc_no', NULL])
            ->andOnCondition(['<>', 'emp_statutorydetails.gmc_no', '']);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false
        ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GMC Annexure List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'empcode',
            'empname',
            [
                'attribute' => 'designation_id',
                'value' => 'designation.designation',
            ],
            [
                'attribute' => 'division_id',
                'value' => 'division.division_name',
            ],
            [
                'attribute' => 'unit_id',
                'value' => 'units.name',
            ],
            [
                'attribute' => 'Policy No',
                'value' => 'employeeStatutoryDetail.gmc_no',
            ],
            ['label' => 'Valid From',
                'format' => ['date', 'php:d-m-Y'],
                'value' => function ($model) {
                    $vf = VgGmcPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gmc_no])->one();
                    $evf = VgGmcEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gmc_no])->one();
                    if ($vf['policy_no'] == $model->employeeStatutoryDetail->gmc_no) {
                        return $vf['from_date'];
                    } else if ($evf['endorsement_no'] == $model->employeeStatutoryDetail->gmc_no) {
                        return $evf['start_date'];
                    }
                },
            ],
            ['label' => 'Valid To',
                'format' => ['date', 'php:d-m-Y'],
                'value' => function ($model) {
                    $vt = VgGmcPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gmc_no])->one();
                    $evt = VgGmcEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gmc_no])->one();
                    if ($vt['policy_no'] == $model->employeeStatutoryDetail->gmc_no) {
                        return $vt['to_date'];
                    } else if ($evt['endorsement_no'] == $model->employeeStatutoryDetail->gmc_no) {
                        return $evt['end_date'];
                    }
                },
            ],
            [
                'attribute' => 'Sum Insured',
                'contentOptions' => ['style' => 'text-align: right;'],
                'value' => 'employeeStatutoryDetail.gmc_sum_insured',
            ],
            ['label' => 'Fellow Share',
                'contentOptions' => ['style' => 'text-align: right;'],
                'value' => function ($model) {
                    $vf = VgGmcPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gmc_no])->one();
                    $evf = VgGmcEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gmc_no])->one();

                    if ($vf) {
                        $fs = VgGmcHierarchy::find()->where(['sum_insured' => $model->employeeStatutoryDetail->gmc_sum_insured, 'gmc_policy_id' => $vf->id])->one();
                        return $fs['fellow_share'];
                    } else if ($evf) {
                        $efs = VgGmcEndorsementHierarchy::find()->where(['gmc_endorsement_id' => $evf->id, 'endorsement_sum_insured' => $model->employeeStatutoryDetail->gmc_sum_insured])->one();
                        return $efs['endorsement_fellow_share'];
                    }
                },
            ],
            [
                'attribute' => 'Age Group',
                'value' => 'employeeStatutoryDetail.age_group',
            ],            
        ],
    ]);
    ?>
</div>


