<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Customer */


$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">
  
<div class="panel panel-default">
   <div class="panel-heading text-center">Create Customer</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
