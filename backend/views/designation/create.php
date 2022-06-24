<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Designation */


$this->params['breadcrumbs'][] = ['label' => 'Designations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-create">

<div class="panel panel-default">
   <div class="panel-heading text-center"> Create Designation</div>
  
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
