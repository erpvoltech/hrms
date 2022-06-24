<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGpaEndorsement */

$this->title = 'Create VG GPA Endorsement';
$this->params['breadcrumbs'][] = ['label' => 'VG GPA Endorsements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gpa-endorsement-create">

    <?= $this->render('_form', [
        'endorsmentPolicy' => $endorsmentPolicy,
         'endorsmentHierarchy' => $endorsmentHierarchy,
    ]) ?>
</div>
