<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicy */

$this->title = 'Create VG GMC Policy';
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gmc-policy-create">

    <?= $this->render('_form', [
        'vitalPolicy' => $vitalPolicy,
         'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
