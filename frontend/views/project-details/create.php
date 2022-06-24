<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectDetails */

/*$this->title = 'Create Project Details';
$this->params['breadcrumbs'][] = ['label' => 'Project Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
$this->title = 'Create Project Details';
?>
<div class="project-details-create">

    <h3><?= Html::encode($this->title) ?></h3>
	<br>
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
