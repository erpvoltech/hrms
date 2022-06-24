<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceCompany */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Companies', 'url' => ['index']];
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
<div class="vg-insurance-company-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">ISP View</h5>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr>
                            <th style="text-align : right">Company Name</th><td> <?= $model->company_name ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
