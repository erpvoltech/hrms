<?php
$this->title ='Appointment Order';
$this->params['breadcrumbs'][] = ['label' => 'Emp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$id = $_GET['id'];

 
 ?>
 
 <div class="order-update">
    <?= $this->render('editor-app', [
        'model' => $model,
		]) ?>

</div>