<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Document;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpAddress;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\widgets\Pjax;

$id=$_GET['id'];
$type=$_GET['type'];
$Emp = EmpDetails::findOne($id);
$this->title = 'Show Cause Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">
  <h1><?= Html::encode($this->title) ?></h1>
  <div class="row" id="loading">
	  <div class="col-md-5"></div><div class="col-md-4">
		  <img src="<?php echo Yii::getAlias('@web').'/img/please_wait.gif'; ?>", width="100">		  
	  </div>
  </div>
  <div class="col-md-5 alert alert-success" id="report_sucess"></div>
  <div class="col-md-1"></div>
  <div class="col-md-5 alert alert-danger" id="report_failure" ></div>
    <div class="row">
    <div class="col-md-8"> </div>
    <div class="col-md-2">  <button type="button" name ="sendall" id ="sendall" class="btn btn-success pull-right">Send</button></div>
</div>


  <?php

  $query = Document::find()->where(['type'=>3,'mail'=>0])->orderBy([
    'id' => SORT_DESC,
  ]);
  $dataProvider = new ActiveDataProvider([
    'query' => $query,
  ]); ?>
  <?php
 Pjax::begin(['id' => 'pjax-showcause']);

  echo GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      [ 'class' => 'yii\grid\CheckboxColumn',
          'checkboxOptions' => ["attribute" => 'id'],
      ],

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
            'label'=>'Send mail',
            'format'=>'raw',
            'value' => function($data){
                $url = "send-show-cause?id=".$data->id;
                return Html::a('Send', $url, ['title' => 'Mail']);
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
            },
            'delete' => function($url, $model){
              return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-show-cause', 'id' => $model->id], [
                'class' => '',
                'data' => [
                  'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                  'method' => 'post',
                ],
              ]);
            }
          ],
        ],
      ],
    ]);
    ?>
     <?php Pjax::end(); ?>
    </div>
    <?php
    $script = <<<JS
    $('#report_sucess').hide();
  	$('#report_failure').hide();
	$('#loading').hide();
    $('#sendall').click(function(event){
    var dialog = confirm("Are you sure to Send Mail");
    if(dialog == true) {
	$('#loading').show();
        var keys = $('#w0').yiiGridView('getSelectedRows');
        $.ajax({
          type: "POST",
          url: 'send-all',
          data: {keylist: keys},
          dataType: 'json',
          success: function(data){
		  $('#loading').hide();
            $.each(data.success, function(i,report) {
              $('#report_sucess').show();
              $('#report_sucess').append(report);
            });

            $.each(data.error, function(i,report) {
              $('#report_failure').show();
              $('#report_failure').append(report);
            });
            $.pjax.reload({container: '#pjax-showcause'});
          }
        });
      }
    });
JS;
$this->registerJs($script);
?>
