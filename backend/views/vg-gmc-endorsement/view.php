<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcEndorsement */

$this->title = $model->endorsement_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Endorsements', 'url' => ['index']];
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
<div class="vg-gmc-endorsement-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">GMC Endorsement View</h5>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table  table-condense" style="font-size:12px;" >
                        
                        <tr>
                            <th >Endorsement No</th><td> <?= $model->endorsement_no ?> </td>
                            <th >Valid From</th><td> <?= date('d.m.Y', strtotime($model->start_date)) ?> </td>
                            <th >Valid To</th><td> <?= date('d.m.Y', strtotime($model->end_date)) ?> </td>
                            <th >Premium Paid</th><td colspan="4"> <?= $model->endorsement_premium_paid ?> </td>
                        </tr>
                       
                        <tr><td colspan="8" style="font-size: medium; color: #31708f; background-color: #d9edf7;">GMC Endorsement Hierarchy</td></tr>
                        <tr>
                            <th colspan="3" style="text-align : right;">Sum Insured</th>
                            <th colspan="3" style ="text-align : right;">Fellow Share</th>
                            <th colspan="2" style ="text-align : right;">Age Group</th>
                        </tr>
                        <?php foreach ($gpaEndorseItem as $gpaEndorseModel){ ?>
                        <tr style="text-align: right;">
                            <td colspan="3"><?= $gpaEndorseModel->endorsement_sum_insured ?></td>
                            <td colspan="3"><?= $gpaEndorseModel->endorsement_fellow_share ?></td>
                            <td colspan="2"><?= $gpaEndorseModel->endorsement_age_group ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 

    
