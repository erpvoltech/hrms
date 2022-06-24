<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssueSub */

$this->title = 'Create Vepl Stationaries Issue Sub';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Issue Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-issue-sub-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
