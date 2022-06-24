<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgWcPolicy */

$this->title = 'Update WC Policy: ' . $vitalPolicy->id;
$this->params['breadcrumbs'][] = ['label' => 'WC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $vitalPolicy->id, 'url' => ['view', 'id' => $vitalPolicy->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-wc-policy-update">

     <?= $this->render('_wcupdateform', [
        'vitalPolicy' => $vitalPolicy,
        'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
