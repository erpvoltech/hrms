<?php

namespace backend\controllers;

use Yii;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\Department;
use common\models\Designation;
use common\models\EmpStatutorydetails;
use common\models\Unit;
use common\models\EmpDetailsSearch;
use common\models\EmpRemunerationDetails;
use common\models\PreviousEmployment;
use common\models\EmpSalary;
use app\models\SalaryStatementsearch;
use app\models\AppointmentLetter;
use app\models\EmpSalarystructure;
use app\models\EmpStaffPayScale;
use yii\web\Controller;
use app\models\EmpReportSearch;
use yii\filters\VerbFilter;
use app\models\SalarySearch;
use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\AuthAssignment;
use common\models\SalaryMonth;
use app\models\EmpGratuitySearch;
use app\models\EmpActiveSearch;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '524M');

class ReportController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['create','update','view','delete'],
                'rules' => [
                    // deny all POST requests
                    /* [
                      'allow' => false,
                      'verbs' => ['POST']
                      ], */

                    // allow authenticated users
                    [
                        'allow' => true,
                        'actions' => ['gratuity','voltech-exp','export-voltech-exp','bloodgroup','md-report-export', 'md-report', 'md-report-staff','md-report-slot', 'bankfilter', 'bank-statement', 'salaryreport', 'view', 'manpower-salary',
                            'manpower', 'salary-report', 'reload', 'salary-statement', 'statement', 'statementexport', 'bank-statement-export', 'md-report-engg',
                            'md-report-emp', 'md-emp-statement', 'component-filter', 'component-result', 'component-export','resigned-report','status-report'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('payroll', 'view');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'manpower-salary', 'manpower', 'salary-report', 'reload', 'salary-statement', 'statement', 'statementexport', 'test'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('payroll', 'update');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'manpower-salary', 'manpower', 'salary-report', 'reload', 'salary-statement', 'statement', 'statementexport'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('payroll', 'create');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'delete', 'manpower-salary', 'manpower', 'salary-report', 'reload', 'salary-statement', 'statement', 'statementexport'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('payroll', 'delete');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['attrition', 'dojreport','resigned-report', 'probationreport','exportprobation','exportprobationdata'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return AuthAssignment::Rights('mis', 'view');
                        },
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

    public function actionIndex() {
        // return $this->render('index');
        $searchModel = new EmpReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

	 public function actionGratuity() {
		 
        $searchModel = new EmpGratuitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('gratuity', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionManpower() {
        return $this->render('manpower');
    }
	
	 public function actionBloodgroup() {
      //  return $this->render('bloodgroup');
	     $searchModel = new EmpActiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bloodgroup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAttrition() {
        $model = New EmpSalary();
        $current_month = date("m");
        if ($current_month > 3) {
            $current_year = date("Y");
        } else {
            $current_year = date("Y") - 1;
        }

        if ($model->load(Yii::$app->request->post())) {
            $current_year = $model->month;
            //	return $this->redirect(['attrition','year' => $current_year,'model'=>$model]);
        }
        return $this->render('attrition', [
                    'year' => $current_year,
                    'model' => $model,
        ]);
    }

    public function actionDojreport() {
        $model = new EmpDetails();
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['dojreport', 'doj' => $model->doj, 'dojto' => $model->dojto,'type' => $model->report_type,]);
        }
        return $this->render('dojreport', ['model' => $model,]);
	}

    public function actionStatusReport() {
        $model = new EmpDetails();
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['status-report', 'doj' => $model->doj, 'dojto' => $model->dojto,'type' => $model->status,]);
        }
        return $this->render('status-report', ['model' => $model,]);
    }
	
	public function actionResignedReport() {
        $model = new EmpDetails();
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['resigned-report', 'doj' => $model->doj, 'dojto' => $model->dojto,]);
        }
        return $this->render('resigned-report', ['model' => $model,]);
    }

    public function actionTest() {
        $structure = EmpStaffPayScale::find()->select('salarystructure')->all();
        $mcount = 0;
        foreach ($structure as $Scale) {

            $modelcount = EmpSalary::find()
                    ->where(['salary_structure' => $Scale->salarystructure])
                    ->count();
            $mcount += $modelcount;
        }

        echo $mcount;
    }

    public function actionSalaryreport() {
        return $this->render('salaryreport');
    }
	
	public function actionVoltechExp() {
        return $this->render('voltech-exp');
    }
	public function actionExportVoltechExp(){
        return $this->render('export-voltech-exp');
    }
	
	
    public function actionManpowerSalary() {
        return $this->render('manpower-salary');
    }

    /* public function actionSalaryReport()    {
      return $this->render('salary-report');
      } */

    public function actionReload() {
        if ($post = Yii::$app->request->post()) {
            if (Yii::$app->request->post('reload') == 'submit') {
                $group = $post['Vgunit']['unit_group'];
                $month = $post['Vgunit']['month'];

                return $this->redirect(['salary-report', 'group' => $group, 'month' => $month]);
            } else {
                return $this->redirect(['salary-report']);
            }
        }
    }

    public function actionStatement() {

        if ($post = Yii::$app->request->post()) {
            if (Yii::$app->request->post('statement') == 'submit') {
                $group = $post['SalaryStatementsearch']['unit_group'];
                $unit = $post['SalaryStatementsearch']['unit_id'];
                $month = $post['SalaryStatementsearch']['salarymonth'];
                $month = '01-' . $month;
                $month_date = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
                return $this->redirect(['statementexport', 'group' => $group, 'month' => $month_date, 'unit' => $unit]);
                //return $this->redirect(['salary-statement','month'=>$month_date]);
            } else {
                return $this->redirect(['salary-statement']);
            }
        }
    }

    public function actionBankfilter() {

        if ($post = Yii::$app->request->post()) {
            if (Yii::$app->request->post('bankfilter') == 'submit') {
                $group = $post['SalaryStatementsearch']['unit_group'];
                $unit = $post['SalaryStatementsearch']['unit_id'];
                $month = $post['SalaryStatementsearch']['salarymonth'];
                $month = '01-' . $month;
                $month_date = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
                return $this->redirect(['bank-statement', 'group' => $group, 'month' => $month_date, 'unit' => $unit]);
            } else {
                return $this->redirect(['bank-statement']);
            }
        }
    }

    /* public function actionComponentFilter()    {
      if ($post = Yii::$app->request->post()) {
      if (Yii::$app->request->post('componentfilter') == 'submit') {
      $group = $post['SalaryStatementsearch']['unit_group'];
      $unit = $post['SalaryStatementsearch']['unit_id'];
      $month = $post['SalaryStatementsearch']['salarymonth'];
      $month = '01-' . $month;
      $month_date = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
      return $this->redirect(['component-result','group' => $group,'month'=>$month_date,'unit'=>$unit]);
      }  else {
      return $this->redirect(['component-result']);
      }
      }
      }

      public function actionComponentExport() {
      return $this->render('component-export');
      }
     */

    public function actionComponentResult() {
        $searchModel = new SalarySearch();		
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('component-result', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        //return $this->render('component-result');
    }

    public function actionSalaryStatement() {
        return $this->render('salary-statement');
    }

    public function actionBankStatement() {
        return $this->render('bank-statement');
    }

    public function actionStatementexport() {
        return $this->render('statementexport');
    }

    public function actionBankStatementExport() {
        return $this->render('bank-statement-export1');
    }

    public function actionMdReport() {
        return $this->render('md-report');
    }

    public function actionMdReportStaff() {
        return $this->render('md-report-staff');
    }
     public function actionMdReportSlot() {
        return $this->render('md-report-slot');
    }

    public function actionMdReportEngg() {
        return $this->render('md-report-engg');
    }

    public function actionMdReportExport() {
        return $this->render('md-report-export');
    }

    public function actionMdReportEmp() {
        return $this->render('md-report-emp');
    }
	
	public function actionProbationreport(){
        return $this->render('probationreport');
    }
	
	public function actionExportprobation() {
        return $this->render('exportprobation');
    }

    public function actionExportprobationdata() {
        return $this->render('exportprobationdata');
    }

    public function actionMdEmpStatement() {

        if ($post = Yii::$app->request->post()) {
            if (Yii::$app->request->post('statement') == 'submit') {
                $group = $post['SalaryStatementsearch']['unit_group'];
                $unit = $post['SalaryStatementsearch']['unit_id'];
                return $this->redirect(['md-report-emp', 'group' => $group, 'unit' => $unit]);
                //return $this->redirect(['salary-statement','month'=>$month_date]);
            } else {
                return $this->render('md-emp-statement');
            }
        } else {
            return $this->render('md-emp-statement');
        }
    }

}
