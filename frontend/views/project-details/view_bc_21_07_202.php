<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\District;
use common\models\State;
use common\models\ProjectDetails;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Project Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-details-view">

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
            'project_code',
            'project_name',
			'pono',
			'po_deliverydate',
            'location_code',
            //'location',
            //'zone',
            'principal_employer',
            //'employer_contact',
            'customer_id',
            //'customer_contact',
            'job_details:ntext',
            'state',
			'district',
            'compliance_required',
            'consultant',
            'consultant_id',
            //'consultant_contact',
            'project_status',
            //'unit_id',
            //'division_id',
            'remark:ntext',
			'pehr_contact',
			'pehr_email',
			'petech_contact',
			'petech_email',
			'conhr_contact',
			'conhr_email',
			'contech_contact',
			'contech_email',
			'consulthr_contact',
			'consulthr_email',
			'consultech_contact',
			'consultech_email',
        ],
    ]) ?>

</div>
