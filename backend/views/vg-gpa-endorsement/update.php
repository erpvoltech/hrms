<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaEndorsement */

$this->title = 'Update VG GPA Endorsement: ' . $endorsmentPolicy->endorsement_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GPA Endorsements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $endorsmentPolicy->endorsement_no, 'url' => ['view', 'id' => $endorsmentPolicy->endorsement_no]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vg-gpa-endorsement-update">

   <?= $this->render('_endorsementform', [
        'endorsmentPolicy' => $endorsmentPolicy,
         'endorsmentHierarchy' => $endorsmentHierarchy,
    ]) ?>

</div>
