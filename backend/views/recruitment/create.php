<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recruitment */


$this->params['breadcrumbs'][] = ['label' => 'Recruitments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
