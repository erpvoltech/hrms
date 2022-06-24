<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgWcPolicy */

$this->title = 'Create VG WC Policy';
$this->params['breadcrumbs'][] = ['label' => 'VG WC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-wc-policy-create">

     <?= $this->render('_form', [
        'vitalPolicy' => $vitalPolicy,
         'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
