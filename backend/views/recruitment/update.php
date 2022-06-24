<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitment */

$this->title = 'Update Recruitment';
?>
<div class="recruitment-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_formEdit', [
        'model' => $model,
    ]) ?>

</div>
