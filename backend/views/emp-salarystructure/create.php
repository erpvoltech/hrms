<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmpSalarystructure */

$this->title = 'Create Emp Salarystructure';
$this->params['breadcrumbs'][] = ['label' => 'Emp Salarystructures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-salarystructure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
