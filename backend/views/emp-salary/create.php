<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmpSalary */


$this->params['breadcrumbs'][] = ['label' => 'Emp Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-salary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('salary_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>

</div>
