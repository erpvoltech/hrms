<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Division */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Change Password', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('resetPassword', [
        'model' => $model,
    ]) ?>

</div>
