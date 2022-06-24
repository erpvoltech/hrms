<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\CustomerContact;

$query = CustomerContact::find()->where(['customer_id'=>$model->id]);
	$dataProvider = new ActiveDataProvider([
				'query' => $query,
	 ]);
?>
<div class="customer-index">
    
<div class="panel panel-default">
   <div class="panel-heading">Customers Contact</div>
  <div class="panel-body">  
   

    <?=GridView::widget([
        'dataProvider' => $dataProvider,     
		 'options' => ['style' => 'width:65%'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
               'attribute' => 'customer_id',
               'value' => 'customer.customer_name',
           ],
			
            'contact_person',
			'contact_mobile',
			'contact_email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete} ',
                'buttons' => [                    
					  'update' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['contact-edit','id' => $key->id]);                   
                     },
					  'delete' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-trash"></span>',['contact-delete','id' => $key->id]);                   
                     },
                ],
            ],
        ],
    ]);?>

<br><br>
        <?= Html::a('Create ', ['cust-contact','id'=>$model->id], ['class' => 'btn btn-danger']) ?>
		</div>
    
</div>
</div>
