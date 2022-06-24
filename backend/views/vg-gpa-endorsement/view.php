<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaEndorsement */

$this->title = $model->endorsement_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GPA Endorsements', 'url' => ['index']];
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
<div class="vg-gpa-endorsement-view">
   <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">GPA Endorsement View</h5>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table  table-condense" style="font-size:12px;" >
                        
                        <tr>
                            <th style="text-align : right">Endorsement No</th><td> <?= $model->endorsement_no ?> </td>
                            <th style="text-align : right">Valid From</th><td> <?= date('d.m.Y', strtotime($model->start_date)) ?> </td>
                            <th style="text-align : right">Valid To</th><td> <?= date('d.m.Y', strtotime($model->end_date)) ?> </td>
                            <th style="text-align : right">Premium Paid</th><td colspan="4"> <?= $model->endorsement_premium_paid ?> </td>
                        </tr>
                       
                        <tr><td colspan="12" style="font-size: medium; color: #31708f; background-color: #d9edf7;">GPA Endorsement Hierarchy</td></tr>
                        <tr><th colspan="6" style="text-align : center">Sum Insured</th><th colspan="6" style ="text-align : center">Fellow Share</th></tr>
                        <?php foreach ($gpaEndorseItem as $gpaEndorseModel){ ?>
                        <tr style="text-align: right;"><td colspan="6"><?= $gpaEndorseModel->endorsement_sum_insured ?></td><td colspan="6"><?= $gpaEndorseModel->endorsement_fellow_share ?></td></tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 

    
