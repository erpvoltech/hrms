<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-log-view">

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
            'user',
            'updatedate',
            'designation_from',
            'designation_to',
            'attendance_from',
            'attendance_to',
            'esi_from',
            'esi_to',
            'pf_from',
            'pf_to',
            'pf_ restrict_from',
            'pf_ restrict_to',
            'pli_from',
            'pli_to',
        ],
    ]) ?>

</div>
