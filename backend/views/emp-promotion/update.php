<?php

use yii\helpers\Html;
use common\models\EmpDetails;

$empmodel = EmpDetails::find()->where(['id' => $model->empid])->one();
/* @var $this yii\web\View */
/* @var $model common\models\EmpPromotion */

//$this->title = 'Update Emp Promotion: ' . $empmodel->empcode;
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $empmodel->empcode, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-promotion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
