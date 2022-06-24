<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcEndorsement */

$this->title = 'Update VG GMC Endorsement: ' . $endorsmentPolicy->endorsement_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Endorsements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $endorsmentPolicy->endorsement_no, 'url' => ['view', 'id' => $endorsmentPolicy->endorsement_no]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-gmc-endorsement-update">

   <?= $this->render('_gmcendorsementform', [
        'endorsmentPolicy' => $endorsmentPolicy,
         'endorsmentHierarchy' => $endorsmentHierarchy,
    ]) ?>

</div>
