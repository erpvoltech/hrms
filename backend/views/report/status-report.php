<?php
error_reporting(0);
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use yii\jui\DatePicker;
use yii\data\ActiveDataProvider;
use yii\db\Query;

if ($_GET['doj'] != '') {
    $model->doj = $_GET['doj'];
    $fd = Yii::$app->formatter->asDate($_GET['doj'], "yyyy-MM-dd");
}
if ($_GET['dojto'] != '') {
    $model->dojto = $_GET['dojto'];
    $td = Yii::$app->formatter->asDate($_GET['dojto'], "yyyy-MM-dd");
}


if($_GET['type'] != '') {
  if($_GET['type'] =='birthday' || $_GET['type'] =='dob' || $_GET['type'] =='marriage'){
    $model->report_type = $_GET['type'];
    $type = $_GET['type'];
     $fd = Yii::$app->formatter->asDate($_GET['doj'], "dd");
     $td = Yii::$app->formatter->asDate($_GET['dojto'], "dd");
     
     $fm = Yii::$app->formatter->asDate($_GET['doj'], "MM");
     $tm = Yii::$app->formatter->asDate($_GET['dojto'], "MM");
     
  } else if($_GET['type'] =='yop'){
     $model->report_type = $_GET['type'];
     $type = $_GET['type'];
     $fy = Yii::$app->formatter->asDate($_GET['doj'], "yyyy");
     $ty = Yii::$app->formatter->asDate($_GET['dojto'], "yyyy");
  } else {
    $model->status = $_GET['type'];
    $type = $_GET['type'];
  }

    
}
?>

<div class="emp-details-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-calendar"> Status Report</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'doj')->label('From Date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'dojto')->label('To Date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
        
        <div class="col-sm-4"> 
                    <?=
                    $form->field($model, 'status')->label('Status')->dropDownList(['Active' => 'Active','Non-paid Leave'=>'Non paid Leave','Paid and Relieved' => 'Paid and Relieved','Relieved'=>'Relieved','Transferred'=>'Transferred','Notice Period'=>'Notice Period','Termination'=>'Termination','Exit Formality Inprocess'=>'Exit Formality Inprocess'], ['prompt' => ' '])
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4"></div>
                <div class="form-group col-lg-4">
                    <?= Html::submitButton('Go', ['class' => 'btn btn-primary']) ?>
                </div>
         
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <?php if (isset($_GET['doj']) && isset($_GET['dojto'])) { ?>
            <div>
                <?php
                $query = new Query;
                
      
       //   if($type =='Termination') {
            
           $query = EmpDetails::find()->where(["between",'last_working_date',$fd, $td])->andWhere(['status'=>$type])
            ->orderBy(['doj'=>SORT_ASC,]);          
         // }
          /*else if($type =='Active') {
            
           $query = EmpDetails::find()->where(["between",'last_working_date',$fd, $td])->andWhere(['status'=>'Active'])
            ->orderBy(['doj'=>SORT_ASC,]);          
          }else if($type =='Non paid Leave') {
            
           $query = EmpDetails::find()->where(["between",'last_working_date',$fd, $td])->andWhere(['status'=>'Non paid Leave'])
            ->orderBy(['doj'=>SORT_ASC,]);          
          }*///
               
        //MONTH
 
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50, 
                    ],
                ]);
       
         if($type){
            $gridColumns = [
              ['class' => 'kartik\grid\SerialColumn'],
              'empcode',
              'empname',
              [
                'attribute' => 'designation_id',
                'value' => 'designation.designation',
              ],
              [
                'attribute' => 'division_id',
                'value' => 'division.division_name',
              ],
              [
                'attribute' => 'department_id',
                'value' => 'department.name',
              ],
              [
                'attribute' => 'unit_id',
                'value' => 'units.name',
              ],
              'category',
              ['attribute' => 'Date of Join',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'doj'
              ],
              ['attribute' => 'Last Working Date',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'last_working_date'
              ],              
              'email',
              'mobileno',
              'status',
            ];
        } 
        
          $title = $type. ' Report' . ' From ' . date('d-M-Y', strtotime($fd)) . ' To ' . date('d-M-Y', strtotime($td)); 
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'panel' => [
                        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>' . $title . '</h5>',
                        'type' => 'info',
                    ],
                    'toolbar' => [
                        '{toggleData}',
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'showConfirmAlert' => false,
                            'exportConfig' => [
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => false,
                                ExportMenu::FORMAT_CSV => false,
                               
                            ],
                            'dropdownOptions' => [
                                'label' => 'Export All',
                                'class' => 'btn btn-secondary'
                            ]
                        ]),
                    ],
                ]);
                ?>
            </div>
        <?php } ?>
    </div>
</div>

