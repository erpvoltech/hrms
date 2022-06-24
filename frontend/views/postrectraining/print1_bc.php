<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PorecTrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Post Recruitment Training';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
/*tbody{
	display: none;
}*/
</style>

<div class="porec-training-print1">
<div class="panel panel-info">
    <div class="panel-heading text-center" style="font-size:18px;">Post Recruitment Training</div>
    <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo "<pre>";print_r($_POST);echo "</pre>"; ?>
	
	
	
</div>
</div>
</div>