<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssueSub */

$this->title = 'Update Vepl Stationaries Issue Sub: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Issue Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vepl-stationaries-issue-sub-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
