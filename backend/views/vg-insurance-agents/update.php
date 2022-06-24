<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceAgents */

$this->title = 'Update ISP/Agents: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ISP/Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-insurance-agents-update">

   <?= $this->render('_form1', [
        'model' => $model,
    ]) ?>

</div>
