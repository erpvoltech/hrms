<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicyClaim */

$this->title = 'Create Vg Gpa Policy Claim';
$this->params['breadcrumbs'][] = ['label' => 'Vg Gpa Policy Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gpa-policy-claim-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
