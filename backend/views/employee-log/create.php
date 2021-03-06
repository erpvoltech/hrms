<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmployeeLog */

$this->title = 'Create Employee Log';
$this->params['breadcrumbs'][] = ['label' => 'Employee Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
