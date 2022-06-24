<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VeplStationaries */

$this->title = 'Create Vepl Stationaries';
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
