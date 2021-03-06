<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Document */

$this->title = 'Create Document';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <?= $this->render('_form', [
        'model' => $model,
		'document'=>$document,
		'type'=>$type,
		'empid'=>$empid,
    ]) ?>

</div>
