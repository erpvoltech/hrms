<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceMotherPolicy */

$this->title = 'VG Insurance Mother Policy';
//$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Mother Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-mother-policy-create">

    <!--<h1>< Html::encode($this->title) ></h1>-->

    <?= $this->render('_form', [
        'vitalPolicy' => $vitalPolicy,
         'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
