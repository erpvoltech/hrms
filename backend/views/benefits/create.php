<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmpBenefits */

$this->title = 'Create Emp Benefits';
$this->params['breadcrumbs'][] = ['label' => 'Emp Benefits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-benefits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
