<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Document;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpAddress;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;

$id=$_GET['id'];
$type=$_GET['type'];
$Emp = EmpDetails::findOne($id);
$this->title = $Emp->empname.' => Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">
    <h1><?= Html::encode($this->title) ?></h1>   
	<p>
        <?= Html::a('Create Document', ['create?type='.$type.'&id='.$id], ['class' => 'btn btn-success']) ?>
    </p>
	<?php $query = Document::find()->where(['empid'=>$id,'type'=>$type])->orderBy([
            'id' => SORT_DESC,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); ?>
    <?php 
		
		
			 echo GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'employee.empname',
            'date',
			[
            'attribute'=>'type',
            'content'=>function($data){
			if($data->type==1){
				return 'Bonafide';
				} else if($data->type==2){
                return "Relieving Letter";
				}else if($data->type==3){
                return "Show Cause Notice";
				}
            }
			],           
            [
            'class' => 'yii\grid\ActionColumn', 
			 'template' => '{update} {delete}',
			 'buttons' => [
					'update' => function ($url,$model) {
					return Html::a(
								'<span class="glyphicon glyphicon-eye-open"></span>', 
								$url, ['target' => '_blank']);
					}
					],
			],
        ],
    ]); 
		
		
	
		?>
</div>
