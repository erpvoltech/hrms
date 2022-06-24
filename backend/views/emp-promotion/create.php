<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmpPromotion */

$this->title = 'Create Emp Promotion';
$this->params['breadcrumbs'][] = ['label' => 'Emp Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-promotion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
