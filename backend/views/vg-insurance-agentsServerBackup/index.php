<?php 
use yii\helpers\Html;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\VgInsurancePolicy;

$this->title = 'VG Insurance';
$this->params['breadcrumbs'][] = $this->title;
 
?>
<div class="body-content">
      <section class="content-header">
                
      </section>
     <style>
       table {
    border-collapse: collapse;
    border-spacing: 0;
}
/* Addition */
/* Apply a natural box layout model to all elements */
/* Read this post by Paul Irish: http://paulirish.com/2012/box-sizing-border-box-ftw/ */
 * { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
     </style>
<div class="row">

    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center>  <h3 class="box-title ">Insurance Company</h3></center>

                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">   
                <ul class="ch-grid" >
                    <li>
                        <div class="">
                            <div class="" >
                                <?php
                             $model = VgInsuranceCompany::find()->all();                             
                                foreach($model as $company){                                    
                                    echo  Html::a($company->company_name, 'agentdata?id=' . $company->id, ['target' => '_blank','style'=>'color:#000']).'<br>';                                     
                                }                                
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <?= Html::a('Create New Company/Agents', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>						

    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center>  <h3 class="box-title ">Policies</h3></center>

                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">   
                <ul class="ch-grid">
                    <li>
                        <div class="">
                            <div class="">
                                <?php
                             $model = VgInsurancePolicy::find()->all();                             
                                foreach($model as $policy){                                    
                                    echo  Html::a($policy->policy_type, \yii::$app->homeUrl.'vg-insurance-mother-policy/policydata?id=' . $policy->id, ['target' => '_blank','style'=>'color:#000']).'<br>';                                     
                                }                                
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <!-- Html::a('Create Policy Type/Policy', ['createpolicy'], ['class' => 'btn btn-success']) -->
                <?= Html::a('Create Policy Type/Policy', ['/vg-insurance-mother-policy/create'], ['class' => 'btn btn-success']) ?>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center>  <h3 class="box-title ">Annexure</h3></center>

                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">   
                <ul class="ch-grid" >
                    <li>
                        <div class="">
                            <div class="" >
                                
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <!--<a href="emp-details/index" class="uppercase">Create New Agent</a>-->
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    
</div>

<div class="row">

    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center>  <h3 class="box-title "></h3></center>

                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">   
                <ul class="ch-grid" >
                    <li>
                        <div class="">
                            <div class="" >
                                
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <!--<a href="emp-details/index" class="uppercase">Create New Agent</a>-->
            </div>
            <!-- /.box-footer -->
        </div>
    </div>						

    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center>  <h3 class="box-title "></h3></center>

                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">   
                <ul class="ch-grid" >
                    <li>
                        <div class="">
                            <div class="" >
                                
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <!--<a href="emp-details/index" class="uppercase">Create New Agent</a>-->
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
</div>
</div>

