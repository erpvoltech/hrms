<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceCompany */

//$this->title = 'Create Vg Insurance Company';
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Vg Insurance Company';
?>
<div class="vg-insurance-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
