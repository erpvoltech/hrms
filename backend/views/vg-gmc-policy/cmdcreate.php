<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicy */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Policies', 'url' => ['cmdindex']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gmc-policy-create">
    <?= $this->render('_cmdform', [
        'model' => $model,
    ]) ?>
</div>
