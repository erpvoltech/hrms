<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmpLeaveStaff */


$this->params['breadcrumbs'][] = ['label' => 'Emp Leave Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-leave-staff-create">
<div class="panel panel-default">
   <div class="panel-heading text-center" style="font-size: 18px;">Create Emp Leave Staff</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
