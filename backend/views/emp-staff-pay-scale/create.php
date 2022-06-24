<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmpStaffPayScale */

//$this->title = 'Create Emp Staff Pay Scale';
$this->params['breadcrumbs'][] = ['label' => 'Emp Staff Pay Scales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-staff-pay-scale-create">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Create Emp Staff Pay Scale</div>
  <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>  
