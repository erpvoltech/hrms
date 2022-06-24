<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\spinner\Spinner;
error_reporting(0);
/*
if (Yii::$app->getRequest()->getQueryParam('month')) {
$month = Yii::$app->getRequest()->getQueryParam('month');
} else {
$month ='';
}
echo $month; */

$monthsal ='';
$empidsal= 0;
$deptsal= 0;
$unitsal= 0;
$divisionsal= 0;

if (Yii::$app->request->queryParams['SalaryUploadSearch']["month"]){
  $monthsal = Yii::$app->request->queryParams['SalaryUploadSearch']["month"];
}

if (Yii::$app->request->queryParams['SalaryUploadSearch']["department"])
$deptsal = Yii::$app->request->queryParams['SalaryUploadSearch']["department"];

if (Yii::$app->request->queryParams['SalaryUploadSearch']["unit"])
$unitsal = Yii::$app->request->queryParams['SalaryUploadSearch']["unit"];


if (Yii::$app->request->queryParams['SalaryUploadSearch']["division"])
$divisionsal = Yii::$app->request->queryParams['SalaryUploadSearch']["division"];


?>


<div class="emp-salary-index">
  <div class="row">
    <?php echo $this->render('_searchsalaryattendance', ['model' => $searchModel]); ?>
  </div>
  <br>

  <div class="row" id="loding">
    <div class="form-group col-lg-4 "></div>
    <div class="form-group col-lg-4 ">
      <?=Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center',
        'caption' => 'Please wait &hellip;'
        ])?>
      </div>
    </div>

    <br>
    <?php
    Pjax::begin(['id' => 'pjax-salarygenerate']);

    ?>
    <?=
    GridView::widget([
      'dataProvider' => $dataProvider,

      'toolbar' => [
        Html::a('Refresh', ['salary-refresh'], ['class'=>'btn btn-md btn-success'])
      ],

      'panel' => [
        'type' => 'info',
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Attendance Sheet</h3>',
        //'footer'=>'<button type="button" name ="bulkgenerate" id ="bulkgenerate" class="btn  btn-success pull-right">Generate Selected</button>',
      ],
      'id' => 'grid',
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [ 'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => ["attribute" => 'id'],
      ],
      [
        'attribute' => 'empid',
        'value' => 'employee.empcode',
      ],
      'employee.empname',
      'employee.designation.designation',
      /* [
      'label'=>'Unit',
      'value'=> 'employee.units.name',
    ],
    [
    'label'=>'Department',
    'value'=> 'employee.department.name',
  ], */
  'month',
  //'leavedays',
  'present_days',
  'arrear',
  'advance',
  'special_allowance',
  'over_time',
//  'holiday_pay',
  'mobile',
  'loan',
  'insurance',
  'rent',
  'tds',
  'lwf',
  'others',
  //'status',
  /* [
  'label' => 'Generate',
  'format' => 'raw',
  'value' => function ($data) {
  if($data->status=='Salary Generated'){
  return'';
} else {
return Html::a('<button class="btn-xs btn-success">Generate</button>',['generate-salary','id' => $data->id]);
}
},
], */
[
  'class' => 'yii\grid\ActionColumn',
  'template' => '{update} {delete}',
  'buttons' => [
    'update' => function($url, $model) {
      return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-attendance', 'id' => $model->id], [
        'class' => '',
      ]);
    },
    'delete' => function($url, $model) {
      return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-salary-uploaded', 'id' => $model->id], [
        'class' => '',
        'data' => [
          'confirm' => 'Are you absolutely sure ? You will lose data with this action.',
          'method' => 'post',
        ],
      ]);
    }
  ]
],
],
]);
?>
<?php Pjax::end(); ?>
<div class="row">
  <div class="col-md-5"> </div>
  <div class="col-md-2"> <!-- <button type="button" name ="generateall" id ="generateall" class="btn-xs btn-success pull-right">Generate All</button>--></div>
  <div class="col-md-2">  <button type="button" name ="bulkgenerate" id ="bulkgenerate" class="btn-xs btn-success pull-right">Generate Selected</button></div>
</div>

<div class="col-md-5 alert alert-success" id="report_sucess"></div>
<div class="col-md-1"></div>
<div class="col-md-5 alert alert-danger" id="report_failure" ></div>
</div>
<?php
$script = <<<JS
$('#report_sucess').hide();
$('#report_failure').hide();
$('#loding').hide();

$('#generateall12323').click(function(event) {

  var dialog = confirm("Are you sure to Generate All Employee");
  if (dialog == true) {
    $.ajax({
      type: "POST",
      url: 'generate-all?unit=$unitsal&division=$divisionsal&dept=$deptsal&month=$monthsal',
      dataType: 'json',
      success: function(data){
        $.each(data.success, function(i,report) {
          $('#report_sucess').show();
          $('#report_sucess').append(report);
          $('#loding').hide();
        });
        $.each(data.error, function(i,report) {
          $('#report_failure').show();
          $('#report_failure').append(report);
          $('#loding').hide();
        });
        $.pjax.reload({container: '#pjax-salarygenerate'});
      }
    });
  }
});


$('#bulkgenerate').click(function(event){
  var dialog = confirm("Are you sure to Generate Salary?");
  if (dialog == true) {
    $('#loding').show();
    var keys = $('#grid').yiiGridView('getSelectedRows');

    $.ajax({
      type: "POST",
      url: 'bulkgenerate',
      data: {keylist: keys},
      dataType: 'json',
      success: function(data){
        $.each(data.success, function(i,report) {
          $('#report_sucess').show();
          $('#report_sucess').append(report);
          $('#loding').hide();
        });
        $.each(data.error, function(i,report) {
          $('#report_failure').show();
          $('#report_failure').append(report);
          $('#loding').hide();
        });
        $.pjax.reload({container: '#pjax-salarygenerate'});
      }
    });
  }
});


$("#Eng").click(function() {
  var printWindow = window.open('salary-template-engg?id=1', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
  printWindow.document.title = "Downloading";

  printWindow.addEventListener('load', function () {
    printWindow.close();
  }, true);
});

$("#Staff").click(function() {
  var printWindow = window.open('salary-template-engg?id=2', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
  printWindow.document.title = "Downloading";

  printWindow.addEventListener('load', function () {
    printWindow.close();
  }, true);
});

JS;
$this->registerJs($script);
?>
