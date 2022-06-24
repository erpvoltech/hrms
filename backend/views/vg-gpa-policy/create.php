<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicy */

$this->title = 'Create VG GPA Policy';
$this->params['breadcrumbs'][] = ['label' => 'VG GPA Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gpa-policy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'vitalPolicy' => $vitalPolicy,
         'modelHierarchy' => $modelHierarchy,
    ]) ?>


</div>
