<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceProperty */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'PIS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-property-view">

    <p>
        <!-- Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) -->
        <!-- Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        //    'id',
            'property_type',
            'property_name',
            'property_no',
            'location',
            'user',
            'user_division',
            'equipment_service',
            'remarks',
        ],
    ]) ?>

</div>
