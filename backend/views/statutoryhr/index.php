<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;  
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StatutoryHrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statutory HR';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statutory-hr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php
    Modal::begin([
        'header'=>'<h4>Update Model</h4>',
        'id'=>'update-modal',
        'size'=>'modal-lg'
    ]);

    echo "<div id='updateModalContent'></div>";

    Modal::end();
?>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          [
          'attribute' => 'month',
           'value' => function ($model) {
                      return Yii::$app->formatter->asDate($model->month, "MM-yyyy");
            },
          ], 
		   [
          'attribute' => 'list_no',
		  'format' => 'raw',
           'value' => function ($model) {                   
					  return Html::a('List '.$model->list_no,['pflist?PfListSearch%5Blist_id%5D='.$model->id.'&month='.$model->month]);
            },
           ],   
		   [
			'attribute'=>'trrn_no',
			'value'=> function($data)
					  { 
					  	  return  (!empty($data->trrn_no))? Html::a($data->trrn_no, ['trrnno','id'=>$data->id], ['id' => 'TrrnpopupModal']):Html::a('Add Trrn No', ['trrnno','id'=>$data->id], ['id' => 'TrrnpopupModal']);      
					  },
			 'format' => 'raw'
		],
		[
			'header'=>'Download',
			'value'=> function($data)
					  { 
					  	  return  Html::a('.txt', ['downloadtxt','id'=>$data->id], ['id' => 'downloadtxt']);      
					  },
			 'format' => 'raw'
		],
           

         ['class' => 'yii\grid\ActionColumn',
				 'template' => '{challan-all}'.'&emsp;&emsp;'  .'{list-delete}',
				   'buttons' => [					
					 'challan-all' => function ($url,$model) {
						return Html::a(
							'<span class="glyphicon glyphicon-eye-open
							"></span>', 
							$url);
						},
						
						'list-delete' => function ($url,$model) {
						return Html::a(
							'<span class="glyphicon glyphicon-trash
							"></span>', 
							$url,[
                    	'title' => Yii::t('app', 'ListDelete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);
						},
						
					
					],
				],
        ],
    ]); ?>
</div>
<?php
$script = <<<JS

$('#TrrnpopupModal').click(function(event){        
	 event.preventDefault();
     $('#update-modal').modal('show').find('#updateModalContent').load($(this).attr('value'));
	});
        
});
JS;
$this->registerJs($script);
?>
