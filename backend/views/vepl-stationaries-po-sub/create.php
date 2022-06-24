<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPoSub */

$this->title = 'Create Vepl Stationaries Po Sub';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Po Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-po-sub-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
