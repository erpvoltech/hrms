<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceProperty */

$this->title = 'Create PIS';
$this->params['breadcrumbs'][] = ['label' => 'PIS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-property-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
