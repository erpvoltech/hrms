<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceAgents */

$this->title = 'Create ISP/Agents';
$this->params['breadcrumbs'][] = ['label' => 'ISP/Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-agents-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
