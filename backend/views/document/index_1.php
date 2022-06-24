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
    <?php if($type==1) {
		
		
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
			],
        ],
    ]); 
		} else if($type==2) {
		
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
			],
        ],
    ]); 
		
		
		}else if($type==3){
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
			 'header'=>'Mail',
			 'label' => 'Send Mail',
               'format' => 'raw',
               'value' => function ($model) {
			   if($model->type==3 && $model->mail==0){
				    return Html::a('<span class="glyphicon glyphicon-envelope"> Send </span>', ['showcause-mail', 'id' => $model->id]);              
				   } else {
				    return Html::a('<span class="glyphicon glyphicon-envelope"> Re-send </span>', ['showcause-mail', 'id' => $model->id]);        
				   }                 
               },
			],			
           
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {print}',
				'buttons' => [
					'view' => function ($url,$model) {
						if(!empty($model->file_name)){
								$url = '@web/doc_file/'.$model->file_name;
							return Html::a(
								'<span class="glyphicon glyphicon-eye-open"></span>', 
								$url, ['target' => '_blank']);
						} else {
						    $updatemodel = Document::findOne($model->id);
							$Emp = EmpDetails::findOne($model->empid);
							$empadd = EmpAddress::find()->where(['empid' => $Emp->id])->one();
							$div = Division::find()->where(['id' => $Emp->division_id])->one();
										
							$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
							$model->file_name=$filename;
							$content ='
								<p>'.Html::img("@web/img/letterpad.png").'</p>
								<br></br>
								<h2><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SHOW CAUSE NOTICE</strong></h2>

							<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.date('d/m/Y').'</b></p>

							<p>&nbsp;</p>

							<p><strong>Mr. '.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
							<strong>'.$Emp->designation->designation.'</strong><br>
							<strong>'.$div->division_name.'.</strong></p>

							<p>&nbsp;</p>

							<p>Dear <strong>Mr. '.$Emp->empname.'</strong>,</p>';
							
							$content .= $model->document;
							
							$content .='<p>&nbsp;</p>

							<p>For <strong>VOLTECH Engineers Private Limited,</strong><br>

							'.Html::img("@web/img/seal.png").' <br>

							<strong>E.Kumaresan</strong></p>

							<p><strong>Asst. General Manger &ndash; HR &amp; IR.</strong></p>			
							';
							
									
							$pdf = new Pdf(); 
							$mpdf = $pdf->api; 
							$mpdf->WriteHtml($content); 			
							$mpdf->Output('doc_file/'.$filename, 'F');
							
							
							$updatemodel->file_name = $filename;
							$updatemodel->save();
							
							$url = '@web/doc_file/'.$model->file_name;
							return Html::a(
								'<span class="glyphicon glyphicon-eye-open"></span>', 
								$url, ['target' => '_blank']);
						}					
					},	
					'print' => function ($url,$model) {
					$url = '@web/doc_file/'.$model->file_name;
						return Html::a(
							'<span class="glyphicon glyphicon-print"></span>', 
							$url, ['target' => '_blank']);
					},	
				],
			],
        ],
    ]); 
	
		}?>
</div>
