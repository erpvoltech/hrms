<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgWcPolicy;
use app\models\VgWcHierarchy;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgWcPolicy */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'VG WC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .b{
        color:#fff;
        visibility: hidden
    }
    .text{
        color: #009933 ;
        font-weight:bold;
        font-size:16px;

    }   
    .addrline {
        border-bottom: 1px solid;
        color: #942509;
        font-weight: normal;
        font-size: 14px;
        margin-bottom: 1em;
        padding-bottom: 2px;
    }

</style>
<div class="vg-wc-policy-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">WC View</h5>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table table-condense" style="font-size:12px;" >
                        <tr>
                            <th >Policy Name/Address</th><td> <?= $model->policy_name ?> </td>
                            <th >ISP Name</th><td> <?= $model->company->company_name ?> </td>
                        </tr>
                        <tr>
                            <th >Agent Name</th><td> <?= $model->agent->agent_name ?> </td>
                            <th >Policy No</th><td> <?= $model->policy_no ?> </td>
                        </tr>
                        <tr>
                            <th >Valid From</th><td> <?= $model->from_date ?> </td>
                            <th >Valid To</th><td> <?= $model->to_date ?> </td>
                        </tr>
                        <tr>
                            <th >Premium Paid</th><td> <?= $model->premium_paid ?> </td>
                            <th >Remarks</th><td> <?= $model->remarks ?> </td>
                        </tr>
                        <tr>
                            <th >Employer Name/Address</th><td> <?= $model->employer_name_address ?> </td>
                            <th >Contractor Name/Address</th><td> <?= $model->contractor_name_address ?> </td>
                        </tr>
                        <tr>
                            <th >Nature of Work</th><td> <?= $model->nature_of_work ?> </td>
                            <th >Policy Holder Address</th><td> <?= $model->policy_holder_address ?> </td>
                        </tr>
                        <tr>
                            <th >Project Address</th><td> <?= $model->project_address ?> </td>
                            <th >WC Coverage Days</th><td> <?= $model->wc_coverage_days ?> </td>
                        </tr>
                        <tr>
                            <th >WC Type</th><td colspan="6"> <?= $model->wc_type ?> </td>
                        </tr>
                    </table>
                        <table class="table table-condense" style="font-size:12px;" >
                        <tr><td colspan="12" style="font-size: medium; color: #31708f; background-color: #d9edf7;">WC Hierarchy</td></tr>
                        <tr><th colspan="4" style="text-align : center">Categories</th><th colspan="4" style ="text-align : center">No of persons</th><th colspan="4" style ="text-align : center">Gross Salary Total</th></tr>
                        <?php foreach ($wcItem as $wcModel){ ?>
                        <tr style="text-align: right;"><td colspan="4"><?= $wcModel->categories ?></td><td colspan="4"><?= $wcModel->no_of_persons ?></td><td colspan="4"><?= $wcModel->gross_salary_total ?></td></tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    
