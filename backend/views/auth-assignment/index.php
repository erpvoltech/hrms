<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authentication';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Authentication', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
			[
               'attribute' => 'userid',
               'value' => 'user.username',
           ],           
			[
			'attribute'=>'module',
			'content'=>function($data){
                return strtoupper($data->module);
            }
			],
			[
			'attribute'=>'view_rights',
			'content'=>function($data){
                return $data->view_rights ? 'Allow':'';
            }
			],
			[
			'attribute'=>'create_rights',
			'content'=>function($data){
                return $data->create_rights ? 'Allow':'';
            }
			],
			[
			'attribute'=>'update_rights',
			'content'=>function($data){
                return $data->update_rights ? 'Allow':'';
            }
			],
			[
			'attribute'=>'delete_rights',
			'content'=>function($data){
                return $data->delete_rights ? 'Allow':'';
            }
			],
           
           

            ['class' => 'yii\grid\ActionColumn',
			 'header'=>'Action', 
			'template' => ' {update}  {delete}',
			],
        ],
    ]); ?>
</div>
