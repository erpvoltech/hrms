<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VgInsuranceEndorsement */

$this->title = 'VG Endorsement Policy';
//$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Endorsements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-endorsement-create">

     <!--<h1>< Html::encode($this->title) ></h1>-->

    <?= $this->render('_form', [
        'endorsmentPolicy' => $endorsmentPolicy,
         'endorsmentHierarchy' => $endorsmentHierarchy,
    ]) ?>


</div>
