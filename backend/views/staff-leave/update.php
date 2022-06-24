<?php

use yii\helpers\Html;
use common\models\EmpDetails;

$Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
$this->title = 'Update Leave: ' . $Emp->empcode.'->'.$Emp->empname;
$this->params['breadcrumbs'][] = ['label' => 'Emp Leave Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $Emp->empcode, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-leave-staff-update">
<div class="panel panel-default">
   <div class="panel-heading text-center" style="font-size: 18px;"> Update Staff Leave</div>
  <div class="panel-body">
    <h4><?= Html::encode($this->title) ?></h4>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>