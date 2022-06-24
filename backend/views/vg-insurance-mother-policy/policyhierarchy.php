<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceHierarchy;
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
<div class="vg-insurance-agents-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title" style="text-align: center;">
                    <?php
                    echo 'Mother Policy Hierarchy';
                    ?><br>
                </h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="12">  <div class="addrline"><span class="text">Policy Hierarchy Details</span></div></th></tr>
                        <tr><th>Sum Insured</th><th>Fellow Share</th></tr>
                        <?php
                        $insuranceHierarchy = VgInsuranceHierarchy::find()->all();
                        foreach ($insuranceHierarchy as $policy) {
                            ?>
                            <tr style="text-align: right;">
                                <td><?= $policy->sum_insured ?></td><td><?= $policy->fellow_share ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>