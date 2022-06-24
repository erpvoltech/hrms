<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicy */

$this->title = 'Update VG GMC Policy: ' . $vitalPolicy->policy_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $vitalPolicy->policy_no, 'url' => ['view', 'id' => $vitalPolicy->policy_no]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-gmc-policy-update">

    <?= $this->render('_form', [
        'vitalPolicy' => $vitalPolicy,
         'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
