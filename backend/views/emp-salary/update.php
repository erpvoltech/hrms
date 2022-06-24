<?php

use yii\helpers\Html;
use common\models\EmpLeaveCounter;


$this->params['breadcrumbs'][] = ['label' => 'Emp Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-salary-update">

   <h1><?= Html::encode($this->title) ?></h1>

   <?=
   $this->render('_form', [
       'model' => $model,     
   ])
   ?>

</div>
