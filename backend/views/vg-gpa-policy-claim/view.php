<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicyClaim */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vg Gpa Policy Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-gpa-policy-claim-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'employee_id',
            'policy_serial_no',
            'contact_person',
            'contact_no',
            'nature_of_accident',
            'injury_detail',
            'accident_place_address',
            'accident_time',
            'accident_notes',
            'total_bill_amount',
            'claim_status',
        ],
    ]) ?>

</div>
