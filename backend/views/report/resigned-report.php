<?php
error_reporting(0);
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
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
?>

<div class="emp-details-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-calendar"> Employees Resigned Report</i></div>
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
                $query = EmpDetails::find()->where(["between", "dateofleaving", $fd, $td])
                       // ->andOnCondition(['=', 'status', 'Active'])
						->orderBy(['dateofleaving'=>SORT_ASC,]);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50, 
                    ],
                ]);
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
                    ['attribute' => 'Date of Join',
                        'format' => ['date', 'php:d-m-Y'],
                        'value' => 'doj'
                    ],
                    'email',
                    'mobileno',
                    'dateofleaving',
		            'last_working_date',
		            'resignation_date', 
                ];

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'panel' => [
                        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Employees Resigned List' . ' From ' . date('d-M-Y', strtotime($fd)) . ' To ' . date('d-M-Y', strtotime($td)) . '</h5>',
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

