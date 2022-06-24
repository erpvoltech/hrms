<?php
use common\models\MailCc;
use common\models\EmpDetails;
use common\models\Division;
use common\models\Unit;
use common\models\UnitGroup;	
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

  $query = MailCc::find();         
 
  
    $dataProvider = new ActiveDataProvider([
            'query' => $query,
    ]);
	

echo  GridView::widget([
       'dataProvider' => $dataProvider,     
       'columns' => [           
			[
            'attribute'=>'unit',            
            'content'=>function($data){
				$unit = Unit::find()->where(['id'=>$data->unit])->one();
                return $unit->name;
				}
			],
			[
            'attribute'=>'division',            
            'content'=>function($data){
				$division = Division::find()->where(['id'=>$data->division])->one();
                return $division->division_name;
				}
			],
			[
            'attribute'=>'cc',            
            'content'=>function($data){
				$Empcc = EmpDetails::find()->where(['id'=>$data->cc])->one();
                return $Empcc->empname;
				}
			],
			[
            'attribute'=>'bcc',            
            'content'=>function($data){
				$Empbcc = EmpDetails::find()->where(['id'=>$data->bcc])->one();
                return $Empbcc->empname;
				}
			],
           ['class' => 'yii\grid\ActionColumn',
			'template' => '{config-delete}',
			'buttons' => [
                'config-delete' => function ($url,$model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>', 
                        $url);
                },               
	        ],
		   ],
       ],
   ]);
   
?>

