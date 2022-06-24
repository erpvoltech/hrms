<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicy */

$this->title = 'Update GPA Policy: ' . $vitalPolicy->id;
$this->params['breadcrumbs'][] = ['label' => 'GPA Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $vitalPolicy->id, 'url' => ['view', 'id' => $vitalPolicy->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-gpa-policy-update">
    
     <?= $this->render('_gpaupdateform', [
        'vitalPolicy' => $vitalPolicy,
        'modelHierarchy' => $modelHierarchy,
    ]) ?>

</div>
