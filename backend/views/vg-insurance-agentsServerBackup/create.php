<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceAgents */

$this->title = 'Create Vg Insurance Agents';
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-agents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
