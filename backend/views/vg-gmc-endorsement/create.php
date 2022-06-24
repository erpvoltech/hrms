<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgGmcEndorsement */

$this->title = 'Create VG GMC Endorsement';
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Endorsements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gmc-endorsement-create">

     <?= $this->render('_form', [
        'endorsmentPolicy' => $endorsmentPolicy,
         'endorsmentHierarchy' => $endorsmentHierarchy,
    ]) ?>

</div>
