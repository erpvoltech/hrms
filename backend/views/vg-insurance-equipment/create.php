
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceEquipment */

$this->title = 'Create Policy-Equipment';
$this->params['breadcrumbs'][] = ['label' => 'Policy-Equipments', 'url' => ['equipmentindexnew']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-equipment-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
