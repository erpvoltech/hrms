<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Document */

$this->title = 'Update Document: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-update">
    <?= $this->render('_form', [
        'model' => $model,
		'document'=>$model->document,
		'type'=>$model->type,
		'empid'=>$model->empid,
    ])?>
</div>
