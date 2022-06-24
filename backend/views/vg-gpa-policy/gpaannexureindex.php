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
use app\models\VgGpaPolicy;
use app\models\VgGpaHierarchy;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
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
            ->where(['IS NOT', 'emp_statutorydetails.gpa_no', NULL])
            ->andOnCondition(['<>', 'emp_statutorydetails.gpa_no', '']);

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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GPA Annexure List </h3>',
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
            ['label' => 'GPA Type',
                'format' => 'raw',
                'value' => function ($model) {
                    $gpatype = VgGpaPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    $gpatype1 = VgGpaEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    if ($gpatype['policy_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return $gpatype['gpa_type'];
                    } else if ($gpatype1['endorsement_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return 'Named';
                    }
                },
            ],
            [
                'attribute' => 'Policy No',
                'value' => 'employeeStatutoryDetail.gpa_no',
            ],
            ['label' => 'Valid From',
                'format' => ['date', 'php:d-m-Y'],
                'value' => function ($model) {
                    $vf = VgGpaPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    $evf = VgGpaEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    if ($vf['policy_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return $vf['from_date'];
                    } else if ($evf['endorsement_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return $evf['start_date'];
                    }
                },
            ],
            ['label' => 'Valid To',
                'format' => ['date', 'php:d-m-Y'],
                'value' => function ($model) {
                    $vt = VgGpaPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    $evt = VgGpaEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    if ($vt['policy_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return $vt['to_date'];
                    } else if ($evt['endorsement_no'] == $model->employeeStatutoryDetail->gpa_no) {
                        return $evt['end_date'];
                    }
                },
            ],
            [
                'attribute' => 'Sum Insured',
                'contentOptions' => ['style' => 'text-align: right;'],
                'value' => 'employeeStatutoryDetail.gpa_sum_insured',
            ],
            ['label' => 'Fellow Share',
                'contentOptions' => ['style' => 'text-align: right;'],
                'value' => function ($model) {
                    $vf = VgGpaPolicy::find()->where(['policy_no' => $model->employeeStatutoryDetail->gpa_no])->one();
                    $evf = VgGpaEndorsement::find()->where(['endorsement_no' => $model->employeeStatutoryDetail->gpa_no])->one();

                    if ($vf) {
                        $fs = VgGpaHierarchy::find()->where(['sum_insured' => $model->employeeStatutoryDetail->gpa_sum_insured, 'gpa_policy_id' => $vf->id])->one();
                        return $fs['fellow_share'];
                    } else if ($evf) {
                        $efs = VgGpaEndorsementHierarchy::find()->where(['gpa_endorsement_id' => $evf->id, 'endorsement_sum_insured' => $model->employeeStatutoryDetail->gpa_sum_insured])->one();
                        return $efs['endorsement_fellow_share'];
                    }
                },
            ],
        ],
    ]);
    ?>
</div>


