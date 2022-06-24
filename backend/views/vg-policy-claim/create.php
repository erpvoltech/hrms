<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgPolicyClaim */

$this->title = 'Create Policy Claim';
$this->params['breadcrumbs'][] = ['label' => 'Vg Policy Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-policy-claim-create">
   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
