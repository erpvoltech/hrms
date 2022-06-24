<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssue */

$this->title = 'Update Issued Vepl Stationaries : ' . $modelGrn->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelGrn->id, 'url' => ['view', 'id' => $modelGrn->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-issue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
        'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
