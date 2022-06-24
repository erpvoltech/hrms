<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssue */

$this->title = 'Create Vepl Stationaries Issue';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Issue', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-issue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelGrn' => $modelGrn,
         'modelsGrnItem' => $modelsGrnItem,
    ]) ?>

</div>
