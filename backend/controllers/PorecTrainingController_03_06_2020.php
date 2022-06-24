<?php
namespace backend\controllers;
use Yii;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\PorecTraining;
use app\models\Recruitment;
use app\models\RecruitmentSearch;
use app\models\TrainingBatchSearch;
use app\models\OffeletterrSearch;
use app\models\RecruitmentbatchSearch;
use app\models\SelectedrecruitmentbatchSearch;
use app\models\RecruitmentTrainingSearch;
use app\models\PorecTrainingSearch;
use app\models\TrainingBatch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EmpDetails;
use app\models\EmpDetailsSearch;
use app\models\EmpEcodeSearch;
use common\models\MailForm;
use yii\data\ActiveDataProvider;

use app\models\AuthAssignment;
use yii\filters\AccessControl;
use common\components\AccessRule;

use yii\db\ActiveQuery;
use yii\db\Query;
use dosamigos\ckeditor\CKEditor;

//use YiiMailMessage;

/**
 * PorecTrainingController implements the CRUD actions for PorecTraining model.
 */
class PorecTrainingController extends Controller
{
    /**
     * {@inheritdoc}
     */
	
	public function behaviors()
    {		  
		return [
		'verbs' => [
			   'class' => VerbFilter::className(),
			   'actions' => [
				   'delete' => ['post'],
			   ],
		   ],
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				
				'rules' => [			
					
					// allow authenticated users
					[
						'allow' => true,
						'actions' => ['index','new','view','ajax-getregisterno','ajax-ecode','ajax-ecodeupdate','ajax-exist','ajax-selectedrecriutment','ajax-appendtraining','trainingbatchcreate','trainingbatchstore','trainingprocess','ajax-trainingselection','statusupdate','ajax-offerletterselection','ajax-staffofferletterselection','ajax-bulkofferletterselection','ajax-staffbulkofferletterselection','sendofferletter','sendbulkofferletter','ajax-getofferlettercontent','offerletter','staffofferletter','ajax-selectedecode','ajax-appendecode','joining','joinprocess','joiningecode','assignecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'view');									 
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','new','update','ajax-getregisterno','ajax-ecode','ajax-ecodeupdate','ajax-exist','ajax-selectedrecriutment','ajax-appendtraining','trainingbatchcreate','trainingbatchstore','trainingprocess','ajax-trainingselection','statusupdate','ajax-offerletterselection','ajax-staffofferletterselection','ajax-bulkofferletterselection','ajax-staffbulkofferletterselection','sendofferletter','sendbulkofferletter','ajax-getofferlettercontent','offerletter','staffofferletter','ajax-selectedecode','ajax-appendecode','joining','joinprocess','joiningecode','assignecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'update');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','new','create','ajax-getregisterno','ajax-ecode','ajax-ecodeupdate','ajax-exist','ajax-selectedrecriutment','ajax-appendtraining','trainingbatchcreate','trainingbatchstore','trainingprocess','ajax-trainingselection','statusupdate','ajax-offerletterselection','ajax-staffofferletterselection','ajax-bulkofferletterselection','ajax-staffbulkofferletterselection','sendofferletter','sendbulkofferletter','ajax-getofferlettercontent','offerletter','staffofferletter','ajax-selectedecode','ajax-appendecode','joining','joinprocess','joiningecode','assignecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										return AuthAssignment::Rights('post recruitment', 'create');
							 },
						'roles' => ['@'],
					],
					
					[
						'allow' => true,
						'actions' => ['index','new','delete','ajax-getregisterno','ajax-ecode','ajax-ecodeupdate','ajax-exist','ajax-selectedrecriutment','ajax-appendtraining','trainingbatchcreate','trainingbatchstore','trainingprocess','ajax-trainingselection','statusupdate','ajax-offerletterselection','ajax-staffofferletterselection','ajax-bulkofferletterselection','ajax-staffbulkofferletterselection','sendofferletter','sendbulkofferletter','ajax-getofferlettercontent','offerletter','staffofferletter','ajax-selectedecode','ajax-appendecode','joining','joinprocess','joiningecode','assignecode'],
									  'allow' => true,
									  'matchCallback' => function ($rule, $action) {
										  return AuthAssignment::Rights('post recruitment', 'delete');									 
							 },
						'roles' => ['@'],
					],
					/*[
					'allow' => true,
					'roles' => ['@'],
					]*/
					// everything else is denied
				],
			],
		];
    } 
	 
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all PorecTraining models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PorecTrainingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionNew()
    {
        $model = new PorecTraining();	   

        if ($model->load(Yii::$app->request->post()) ) {
			
			#echo "hi";
			$now_date					=	date("Y-m-d");
			$model->training_startdate	=	date("Y-m-d",strtotime($model->training_startdate));
			$model->training_enddate	=	date("Y-m-d",strtotime($model->training_enddate));			
			$model->created_by			=	Yii::$app->user->identity->username;
			$model->created_date		=	$now_date;	
			$model->recruitment_id		=	implode(',',$_POST['selection']);
			#echo "<pre>";print_r($model);echo "</pre>";
			#exit;			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$model->save(false);		
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;			
			return $this->redirect(['view', 'id' => $model->id]);			
        }
		
		return $this->render('new_create', [
            'model' => $model,
        ]);
    }
	
	public function actionTrainingprocess()
    {
       $model = new PorecTraining();
	   
        /*if ($model->load(Yii::$app->request->post()) ) {						
			$model->save();
			
			return $this->redirect(['send_offerletter', 'id' => $model->id]);
        }*/
		
		return $this->render('offer_letter', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single PorecTraining model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PorecTraining model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PorecTraining();
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		
		
		
        if ($model->load(Yii::$app->request->post()) ) {
			#echo "hi";
			$now_date					=	date("Y-m-d");
			$model->training_startdate	=	date("Y-m-d",strtotime($model->training_startdate));
			$model->training_enddate	=	date("Y-m-d",strtotime($model->training_enddate));
			$model->training_batch_id	=	$model->training_batch_id;
			$model->ecode				=	implode(',',$_POST['selection']);
			$model->created_by			=	Yii::$app->user->identity->username;
			$model->created_date		=	$now_date;	
			
			$model->created_by		=	Yii::$app->user->identity->username;
			$model->created_date	=	$now_date;
			
			#echo "<pre>";print_r($model);echo "</pre>";
			#exit;
			
			$model->save(false);			
			return $this->redirect(['view', 'id' => $model->id]);			
        }

        return $this->render('create', [
          'model' => $model
        ]);
    }

    /**
     * Updates an existing PorecTraining model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionStatusupdate(){
		
		$porecmodel	=	new PorecTraining();
		$model		=	new Recruitment();
		$empmodel		=	new EmpDetails();
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		#$porec_id_str		=	$_POST['PorecTraining']['porec_id'];
		#$porec_id_arr		=	explode(',',$porec_id_str);
		$rec_id_arr			=	$_POST['selection'];		
		$porecmodel 		=	$this->findModel($_POST['porec_id']);
		$porecmodel->status	=	$_POST['PorecTraining']['status'];	
		$porecmodel->save();		
		#echo "<pre>";print_r($porecmodel);echo "</pre>";
		#echo "rec_id: ********* ".$porecmodel->recruitment_id;
		#echo "type: ********* ".$porecmodel->training_type;
		#exit;
		if($porecmodel->training_type == 'new'){
			foreach($rec_id_arr as $res){			
				$model = $this->findRecruitmentModel($res);			
							
				$model->training_id			=	$_POST['porec_id'];
				$model->training_batch_id	=	$_POST['PorecTraining']['training_batch_id'];
				$model->training_status		=	$_POST['PorecTraining']['status'];
				#echo $model->training_status;			
				$model->save(false);		
				#exit;			
				Yii::$app->session->setFlash('success', 'Training Status Successfully Saved. ');
			}
		}
		
		if($porecmodel->training_type == 'existing'){
			foreach($rec_id_arr as $res){			
				#$model = $this->findEmpDetailsModel($res);			
				$empmodel = EmpDetails::findOne($res);		
							
				#$model->training_id			=	$_POST['porec_id'];
				#$model->training_batch_id	=	$_POST['PorecTraining']['training_batch_id'];
				$empmodel->training_status		=	$_POST['PorecTraining']['status'];
				#echo $model->training_status;			
				$empmodel->save(false);		
							
				Yii::$app->session->setFlash('success', 'Training Status Successfully Saved. ');
				
			}
		}
		#exit;
		#if($porecmodel->status == 'selected'){			
		if($porecmodel->status){			
			/*return $this->render('_formofferletter', [
				'model' => $model,
			]);*/
			$this->redirect('trainingprocess');
		}
    }

    /**
     * Deletes an existing PorecTraining model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }	
	
	public function actionAjaxSelectedecode(){
		ob_start();
		$empModel = new EmpDetailsSearch();
		#$recModel = new RecruitmentSearch();
		$data = Yii::$app->request->post();
		#echo "<pre>";print_r($data)	;echo "</pre>";		
		$dataProvider = $empModel->search(['empModel'=>['empcode'=>$data['ecode']]]);
				
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id', "class" => 'ecodecheckbox'],
				],				
				'empname',	
			],
		]);
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){				
				
				$('.ecodecheckbox').click(function(){
					var selectedCheckboxval	=	[];
					//selectedCheckboxval	=	$(this).val();
					
					$('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {						
							selectedCheckboxval.push($(this).val());
							//alert(selectedCheckboxval);
							var hiddenrecruitment_id_exist_ind		=	$('#porectraining-recruitment_id').val();
													
							if(hiddenrecruitment_id_exist_ind != ''){
								var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;
							}
						
							else{
								var str_searchIDs_ind				=	selectedCheckboxval+',';
							}					
							$('#porectraining-recruitment_id').val(str_searchIDs_ind);
							//alert('str_searchIDs_ind: '+str_searchIDs_ind);
							$.post('ajax-appendtraining',{'recId':str_searchIDs_ind},function(datares){	
								$('#trainingbatch_grid').html(datares).show();
								//alert(response);
								//$('#recruitmentbatch_grid').show();
							})
						}						
					});
				});	
				
			});			
		</script>";
		
	}

	public function actionAjaxSelectedrecriutment(){
		ob_start();
		$recModel = new SelectedrecruitmentbatchSearch();
		#$recModel = new RecruitmentSearch();
		
		#echo "<pre>";print_r($_POST);echo "</pre>";
		
		$data 		= 	Yii::$app->request->post();
		$batch_id	=	$_REQUEST['batch'];
		Pjax::begin();
				
		#$dataProvider = $recModel->search('RecruitmentbatchSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentbatchSearch%5Bstatus%5D=selected');$dataProvider = $recModel->search('RecruitmentSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentSearch%5Bstatus%5D=selected');
		$dataProvider = $recModel->search(['recModel'=>['batch_id'=>$batch_id,'status'=>'selected']]);
		$dataProvider->pagination->params = ['batch' => $batch_id];
		$dataProvider->pagination = false;
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			
			//'filterModel' => $recModel,
			'id' => 'grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id', "class" => 'recruitmentcheckbox'],
				],
				'type',
				'name',		
				'register_no',				
				'process_status',								
				//['class' => 'yii\grid\ActionColumn'],
			],
		]);
		Pjax::end();
		echo "<script type='text/javascript'>
			$('document').ready(function(){

				
				$('.select-on-check-all').click(function() {												
					if($('#recruitmentbatch_grid  .select-on-check-all').prop('checked') == true){					 
						$('#recruitmentbatch_grid  input[type=checkbox]').attr('checked', true);
						$('#recruitmentbatch_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#recruitmentbatch_grid  input[type=checkbox]').attr('checked', false);
					$('#recruitmentbatch_grid  .select-on-check-all').val('check all');					
				  }
				});
					
				
				/*$('.recruitmentcheckbox').click(function(){
					var selectedCheckboxval	=	[];
					//selectedCheckboxval	=	$(this).val();
					
					$('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {						
							selectedCheckboxval.push($(this).val());
							//alert(selectedCheckboxval);
							var hiddenrecruitment_id_exist_ind		=	$('#porectraining-recruitment_id').val();
													
							if(hiddenrecruitment_id_exist_ind != ''){
								var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;
							}
						
							else{
								var str_searchIDs_ind				=	selectedCheckboxval+',';
							}					
							$('#porectraining-recruitment_id').val(str_searchIDs_ind);
							//alert('str_searchIDs_ind: '+str_searchIDs_ind);
							$.post('ajax-appendtraining',{'recId':str_searchIDs_ind},function(datares){	
								$('#trainingbatch_grid').html(datares).show();
								//alert(response);
								//$('#recruitmentbatch_grid').show();
							})
						}						
					});
				});*/				
			});			
		</script>";
		
	}	
	
	public function actionAjaxAppendtraining(){
		$recModel = new RecruitmentTrainingSearch();
		$data = Yii::$app->request->post();
		
		$recIdArr	=	explode(', ',$data['recId']);
		$dataProvider = $recModel->search(['recModel'=>['rec_id'=>$data['recId']]]);
		
		
		
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'training_grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				/*['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id'],
				],*/
				'type',
				'name',		
				'register_no',				
				'status',								
				//['class' => 'yii\grid\ActionColumn'],
			],
		]);
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				$('#trainingbatch_grid .select-on-check-all').click(function() {												
					if($('#trainingbatch_grid  .select-on-check-all').prop('checked') == true){					 
						$('#trainingbatch_grid  input[type=checkbox]').attr('checked', true);
						$('#trainingbatch_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#trainingbatch_grid  input[type=checkbox]').attr('checked', false);
					$('#trainingbatch_grid  .select-on-check-all').val('check all');					
				  }
				});
			});
		</script>";		
	}
	
	public function actionAjaxAppendecode(){
		$empModel = new EmpEcodeSearch();
		$data = Yii::$app->request->post();
		
		#$recIdArr	=	explode(', ',$data['recId']);
		#$dataProvider = $recModel->search(['recModel'=>['rec_id'=>$data['recId']]]);
		
		#$query = EmpDetails::find()->where(['id' => $data['ecodeId']]);
		/*$ecodeIdArr		=	explode(', ',$data['ecodeId']);
		#echo str_replace("'',", ',,', $ecodeIdArr[0]);
		$ecodetrimarr	=	explode(',',$ecodeIdArr[0]);		
		foreach($ecodetrimarr as $key=>$value)
		{
			if(is_null($value) || $value == '')
				unset($ecodetrimarr[$key]);
		}
		$ecodetrimstr	=	implode(',',$ecodetrimarr);
		$ecodeArr[]		=	$ecodetrimstr;
		echo "<pre>";print_r($ecodeArr[0]);echo "</pre>";
		#echo $ecodeIdArr[0];
		#$query = EmpDetails::find()->where(['id'=>$ecodeIdArr]);
		#$query	=	"SELECT * FROM `emp_details` WHERE `id` IN ($ecodeIdArr)";
		#$query	=	$qryemp->createCommand();
		#echo "Query: ".$query->createCommand()->getRawSql();	
		$query = EmpDetails::find()->andfilterwhere(['IN', 'id', [$ecodeArr[0]]]);
		#$query	=	"SELECT * FROM `emp_details` WHERE `id` IN ($ecodeIdArr)";
		echo "Query: ".$query->createCommand()->getRawSql();	
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);*/
		
		$ecodeIdArr	=	explode(', ',$data['ecodeId']);
		$dataProvider = $empModel->search(['empModel'=>['ecode_id'=>$data['ecodeId']]]);
		
		
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'training_grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id'],
				],
				'empcode',
				'empname',
			],
		]);
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				$('#trainingbatch_grid .select-on-check-all').click(function() {												
					if($('#trainingbatch_grid  .select-on-check-all').prop('checked') == true){					 
						$('#trainingbatch_grid  input[type=checkbox]').attr('checked', true);
						$('#trainingbatch_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#trainingbatch_grid  input[type=checkbox]').attr('checked', false);
					$('#trainingbatch_grid  .select-on-check-all').val('check all');					
				  }
				});
			});
		</script>";		
	}
		
	/*public function actionAjaxEcode()
    {		
			$data = Yii::$app->request->post();						
			$division 	=	$data['division'];
			$unit 		=	$data['unit'];
			$department = 	$data['department'];			
			$query = EmpDetails::find()->where(['division_id' => $division,'unit_id' => $unit,'department_id' => $department]);			
						
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
			
			echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'ecode_grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id', "class" => 'ecodecheckbox'],
				],	
				'empcode',
				'empname',	
			],
		]);
			
		echo "<script type='text/javascript'>
			$('document').ready(function(){				
				
				$('.ecodecheckbox').click(function(){
					var selectedCheckboxval	=	[];
					//selectedCheckboxval	=	$(this).val();
					
					$('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {						
							selectedCheckboxval.push($(this).val());
							//alert(selectedCheckboxval);
							var hiddenrecruitment_id_exist_ind		=	$('#porectraining-ecode_id').val();
													
							if(hiddenrecruitment_id_exist_ind != ''){
								var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;								
							}
						
							else{
								//var str_searchIDs_ind				=	selectedCheckboxval;
								var str_searchIDs_ind				=	selectedCheckboxval+',';
							}					
							$('#porectraining-ecode_id').val(str_searchIDs_ind);
							//alert('str_searchIDs_ind: '+str_searchIDs_ind);
							$.post('ajax-appendecode',{'ecodeId':str_searchIDs_ind},function(datares){
								$('#ecode_grid  input[type=checkbox]').prop('checked', false);								
								$('#trainingbatch_grid').html(datares).show();									
							})
						}						
					});
				});
				
				$('#ecode_grid .select-on-check-all').click(function() {	
					//alert('checked');
					if($('#ecode_grid  .select-on-check-all').prop('checked') == true){
						
						$('#ecode_grid  input[type=checkbox]').attr('checked', true);
						$('#ecode_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#ecode_grid  input[type=checkbox]').attr('checked', false);
					$('#ecode_grid  .select-on-check-all').val('check all');					
				  }
				});				
			});			
		</script>";				
    }*/
	
	public function actionAjaxEcode()
    {		
			ob_start();
			$data = Yii::$app->request->post();
						
			$empModel = new EmpDetails();	
			$query = EmpDetails::find()->where(['status'=>'active'])->orderBy(['empcode' => SORT_ASC]);
						
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => false,
			]);
			echo '<div style="width: 600px; height: 500px; overflow: auto; padding: 10px;">';
			echo GridView::widget([
				'dataProvider' => $dataProvider,
				//'filterModel' => $empModel,
				'id' => 'ecode_grid',		
				'columns' => [
					['class' => 'yii\grid\SerialColumn'], 						
					['class' => 'yii\grid\CheckboxColumn',
						'checkboxOptions' => ["attribute" => 'id', "class" => 'ecodecheckbox'],
					],	
					'empcode',
					'empname',	
				],				
			]);
		echo '</div></br></br>';
		/*echo $this->registerJs('$("body").on("keyup.yiiGridView", "#ecode_grid .filters input", function(){
					$("#ecode_grid").yiiGridView("applyFilter");
				})', \yii\web\View::POS_READY);*/
			
		echo "<script type='text/javascript'>
			$('document').ready(function(){	

				$('body').on('keyup.yiiGridView', '#ecode_grid .filters input', function(){
					$('#ecode_grid').yiiGridView('applyFilter');
				})
				
				$('.ecodecheckbox').click(function(){
					var selectedCheckboxval	=	[];
					//selectedCheckboxval	=	$(this).val();
					
					$('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {						
							selectedCheckboxval.push($(this).val());
							//alert(selectedCheckboxval);
							var hiddenrecruitment_id_exist_ind		=	$('#porectraining-ecode_id').val();
													
							if(hiddenrecruitment_id_exist_ind != ''){
								var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;								
							}
						
							else{
								//var str_searchIDs_ind				=	selectedCheckboxval;
								var str_searchIDs_ind				=	selectedCheckboxval+',';
							}					
							$('#porectraining-ecode_id').val(str_searchIDs_ind);
							//alert('str_searchIDs_ind: '+str_searchIDs_ind);
							$.post('ajax-appendecode',{'ecodeId':str_searchIDs_ind},function(datares){
								$('#ecode_grid  input[type=checkbox]').prop('checked', false);								
								$('#trainingbatch_grid').html(datares).show();									
							})
						}							
					});
				});
				
				$('#ecode_grid .select-on-check-all').click(function() {	
					//alert('checked');
					if($('#ecode_grid  .select-on-check-all').prop('checked') == true){
						
						$('#ecode_grid  input[type=checkbox]').attr('checked', true);
						$('#ecode_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#ecode_grid  input[type=checkbox]').attr('checked', false);
					$('#ecode_grid  .select-on-check-all').val('check all');					
				  }
				});				
			});			
		</script>";				
    }
	
	public function actionAjaxEcodeupdate()
    {		
			ob_start();						
			$data = Yii::$app->request->post();
			
			$trainingmodel	=	new PorecTraining();
			$trainingqry	=	PorecTraining::find()->where(['id'=>$_POST['training_id']])->one();
			
			#echo "<pre>".$trainingqry->recruitment_id;echo "</pre>";
			#exit;
			
			/*$recModel		=	new Recruitment();
			$recqry			=	Recruitment::find()->where(['id']);
			
			$empModel = new EmpDetails();	
			$query = EmpDetails::find()->where(['status'=>'active'])->orderBy(['empcode' => SORT_ASC]);
						
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => false,
			]);
			echo '<div style="width: 600px; height: 500px; overflow: auto; padding: 10px;">';
			echo GridView::widget([
				'dataProvider' => $dataProvider,
				//'filterModel' => $empModel,
				'id' => 'ecode_grid',		
				'columns' => [
					['class' => 'yii\grid\SerialColumn'], 						
					['class' => 'yii\grid\CheckboxColumn',
						'checkboxOptions' => ["attribute" => 'id', "class" => 'ecodecheckbox'],
					],	
					'empcode',
					'empname',	
				],				
			]);*/
		$recModel = new RecruitmentTrainingSearch();
		$recIdArr	=	explode(', ',$trainingqry->recruitment_id);
		$dataProvider = $recModel->search(['recModel'=>['rec_id'=>$trainingqry->recruitment_id]]);
		
		
		
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'training_grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				
				'type',
				'name',		
				'register_no',				
				'status',								
				//['class' => 'yii\grid\ActionColumn'],
			],
		]);
			
		echo '</div></br></br>';
		/*echo $this->registerJs('$("body").on("keyup.yiiGridView", "#ecode_grid .filters input", function(){
					$("#ecode_grid").yiiGridView("applyFilter");
				})', \yii\web\View::POS_READY);*/
			
		echo "<script type='text/javascript'>
			$('document').ready(function(){	

				$('body').on('keyup.yiiGridView', '#ecode_grid .filters input', function(){
					$('#ecode_grid').yiiGridView('applyFilter');
				})
				
				$('.ecodecheckbox').click(function(){
					var selectedCheckboxval	=	[];
					//selectedCheckboxval	=	$(this).val();
					
					$('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {						
							selectedCheckboxval.push($(this).val());
							//alert(selectedCheckboxval);
							var hiddenrecruitment_id_exist_ind		=	$('#porectraining-ecode_id').val();
													
							if(hiddenrecruitment_id_exist_ind != ''){
								var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;								
							}
						
							else{
								//var str_searchIDs_ind				=	selectedCheckboxval;
								var str_searchIDs_ind				=	selectedCheckboxval+',';
							}					
							$('#porectraining-ecode_id').val(str_searchIDs_ind);
							//alert('str_searchIDs_ind: '+str_searchIDs_ind);
							$.post('ajax-appendecode',{'ecodeId':str_searchIDs_ind},function(datares){
								$('#ecode_grid  input[type=checkbox]').prop('checked', false);								
								$('#trainingbatch_grid').html(datares).show();									
							})
						}							
					});
				});
				
				$('#ecode_grid .select-on-check-all').click(function() {	
					//alert('checked');
					if($('#ecode_grid  .select-on-check-all').prop('checked') == true){
						
						$('#ecode_grid  input[type=checkbox]').attr('checked', true);
						$('#ecode_grid  .select-on-check-all').val('uncheck all');																							
				  } else {
					$('#ecode_grid  input[type=checkbox]').attr('checked', false);
					$('#ecode_grid  .select-on-check-all').val('check all');					
				  }
				});
				
			});			
		</script>";				
    }
	
	public function actionAjaxExist(){
		#if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();
			$name = explode(":", $data['name']);
			$batch = explode(":", $data['batch']);
			$startDate = explode(":", $data['startDate']);
			$endDate = explode(":", $data['endDate']);
			$action = explode(":", $data['action']);
			if($action == 'create'){
				$existqry = PorecTraining::find()->where(['name' => $name,'batch_id' => $batch])->all();			
			}
			if($action == 'update'){
				$existqry = PorecTraining::find()->where(['name' => $name,'batch_id' => $batch])->all();			
			}
			#$existqry = PorecTraining::find()->where(['ecode' => $ecode,'batch_id' => $batch])->all();			
			echo $cnt	=	count($existqry);
			#echo "<pre>";print_r($ecode);echo "</pre>";						
		#}
	}
	
	public function actionAjaxGetregisterno(){
		if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();
			
			$id = explode(":", $data['id']);
			$recruitment = Recruitment::find()->where(['id' => $id])->one();			
			#$existqry = PorecTraining::find()->where(['ecode' => $ecode,'batch_id' => $batch])->all();			
			echo $recruitment->register_no;
		}
	}
		
	public function actionTrainingbatchcreate()
    {
        $model = new TrainingBatch();
		return $this->renderAjax('trainingbatchcreate', [
                'model' => $model,
            ]);
			/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('trainingbatchcreate', [
                'model' => $model,
            ]);
        } */
    }
	
	public function actionTrainingbatchstore()
    {         
        $model = new TrainingBatch();      
        return $this->renderAjax('trainingbatchstore', [
                'model' => $model,
        ]);
    }		
	
	/****************  Offer Letter Generate  *****************************/
	
	public function actionAjaxTrainingselection(){
		ob_start();
		$recModel = new TrainingBatchSearch();
		$data = Yii::$app->request->post();
		$recruitment_arr	=	[];	
		#$dataProvider = $recModel->search('RecruitmentbatchSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentbatchSearch%5Bstatus%5D=selected');$dataProvider = $recModel->search('RecruitmentSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentSearch%5Bstatus%5D=selected');
		
		$trainigqry		=	PorecTraining::find()->where(['training_batch_id'=>$data['training_batch_id']])->all();
		#echo "<pre>";print_r($trainigqry);echo "</pre>";
		
		echo "<table class='table'> <th><input type='checkbox' name='selection_all' class='select-on-check-all' id='selectall' value='1' ></th> <th>Name</th> <th>Training Start</th> <th>Training End</th>";
			$lp	=	0;
			foreach($trainigqry as $restraining){
				$recruitment_arr[$lp]['rec_id']			=	explode(',',$restraining->recruitment_id);
				$recruitment_arr[$lp]['ecode_id']		=	explode(',',$restraining->ecode);
				
				$recruitment_arr[$lp]['training_id']	=	$restraining->id;
				$lp++;				
			}	
				#echo "<pre>";print_r($recruitment_arr);echo "</pre>";		
				
				for($i=0;$i<count($recruitment_arr);$i++){
					if(count($recruitment_arr[$i]['rec_id']) > 0){						
						for($j=0;$j<count($recruitment_arr[$i]['rec_id']);$j++){
							
							if($recruitment_arr[$i]['rec_id'][$j] != ''){
								#echo "</br> recruitment_arr: ". $recruitment_arr[$i]['rec_id'][$j];
								$model	=	new Recruitment();
								if(is_numeric($recruitment_arr[$i]['rec_id'][$j])){
									$recquery_rec = Recruitment::find()->where(['id'=>$recruitment_arr[$i]['rec_id'][$j]])->one();
									#echo "<pre>";print_r($recquery_rec);echo "</pre>";
									#exit;
									$recname	  	=	$recquery_rec['name'];
								}else{
									$recname		=	$recruitment_arr[$i]['rec_id'][$j];
								}
								$trngquery_rec = PorecTraining::find()->where(['id'=>$recruitment_arr[$i]['training_id']])->one();							
								#echo $recquery_rec->createCommand()->getRawSql();
								#echo "<pre>";print_r($recquery_rec);echo "</pre>";
								#echo '<tr>								
										#<td><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$trngquery_rec->id.'></td>
								echo '<tr>
										<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$recruitment_arr[$i]['rec_id'][$j].'></td>
										<td>'.$recname.'</td>									
										<td>'.$trngquery_rec->training_startdate.'</td>
										<td>'.$trngquery_rec->training_enddate.'</td>									
									  </tr>';					  
							}
						}
					}
					if(count($recruitment_arr[$i]['ecode_id']) >0){						
							
							for($j=0;$j<count($recruitment_arr[$i]['ecode_id']);$j++){
							
								if($recruitment_arr[$i]['ecode_id'][$j] != ''){
									#echo "</br> recruitment_arr: ". $recruitment_arr[$i]['rec_id'][$j];
									$empmodel	=	new EmpDetails();
									if(is_numeric($recruitment_arr[$i]['ecode_id'][$j])){
										$empquery_rec = EmpDetails::find()->where(['id'=>$recruitment_arr[$i]['ecode_id'][$j]])->one();
										#echo "<pre>";print_r($recquery_rec);echo "</pre>";
										#exit;
										$empname	  	=	$empquery_rec['empname'];
									}else{
										$empname		=	$recruitment_arr[$i]['ecode_id'][$j];
									}
									$trngquery_rec = PorecTraining::find()->where(['id'=>$recruitment_arr[$i]['training_id']])->one();							
									#echo $recquery_rec->createCommand()->getRawSql();
									#echo "<pre>";print_r($recquery_rec);echo "</pre>";
									#echo '<tr>								
											#<td><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$trngquery_rec->id.'></td>
									echo '<tr>
											<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$recruitment_arr[$i]['ecode_id'][$j].'></td>
											<td>'.$empname.'</td>									
											<td>'.$trngquery_rec->training_startdate.'</td>
											<td>'.$trngquery_rec->training_enddate.'</td>									
										  </tr>';					  
								}
							}
						
					}
				}
					
		echo "</table>";
		
		/*$dataProvider = $recModel->search(['recModel'=>['training_batch_id'=>$data['training_batch_id']]]);				
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			//'filterModel' => $recModel,
			'id' => 'grid',		
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 						
				['class' => 'yii\grid\CheckboxColumn',
					'checkboxOptions' => ["attribute" => 'id', "class" => 'recruitmentcheckbox'],
				],
				'recruitment_id',
				'training_startdate',		
				'training_enddate',						
				//['class' => 'yii\grid\ActionColumn'],
			],
		]);*/
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				$('#trainingbatch_grid .select-on-check-all').click(function() {												
					if($('#trainingbatch_grid  .select-on-check-all').prop('checked') == true){					 
						//$('#trainingbatch_grid  input[type=checkbox]').attr('checked', true);
						
						/*if ($('#selectall').prop('checked') == true) {
							$('.recruitmentcheckbox').prop('checked', true);
							$('#selectall').attr('checked', false);
						} else {
							$('.recruitmentcheckbox').prop('checked', false);
							$('#selectall').attr('checked', 'true');
						}*/
						
						$('.recruitmentcheckbox').prop('checked', true);
						$('#trainingbatch_grid  .select-on-check-all').val('uncheck all');						
						
						var searchIDs = [];

						$('#trainingbatch_grid input:checkbox:checked').map(function(){
							if($(this).val() != 'uncheck all'){
								searchIDs.push($(this).val());		
							}
						});
						
						var str_searchIDs_new 				= 	searchIDs.toString();						
						$('#porectraining-rec_id').val(str_searchIDs_new);
						var hiddenrecruitment_id_exist		=	$('#porectraining-rec_id').val();						
						//alert('hiddenrecruitment_id_exist: '+hiddenrecruitment_id_exist);
						
						/*if(hiddenrecruitment_id_exist != ''){
							var str_searchIDs				=	hiddenrecruitment_id_exist + ',' + str_searchIDs_new;
						}
					
						else{
							var str_searchIDs				=	str_searchIDs_new;
						}
						
						//alert('str_searchIDs: '+str_searchIDs);
						
						//alert('str_searchIDs: '+str_searchIDs);
						$('#porectraining-porec_id').val(str_searchIDs);
						
						//alert('str_searchIDs: '+str_searchIDs);
						//$('#trainingbatch_grid').html('');
						
						$.post('ajax-appendtraining',{'recId':str_searchIDs},function(datares1){	
							$('#trainingbatch_grid').html(datares1).show();
							//alert(response);
							//$('#recruitmentbatch_grid').show();
						})*/					
				  } if($('#trainingbatch_grid  .select-on-check-all').prop('checked') == false){
					$('.recruitmentcheckbox').prop('checked', false);
					//$('#trainingbatch_grid input[type=checkbox]').removeAttr('checked');
					$('#trainingbatch_grid  .select-on-check-all').val('check all');
					
					/*var unchecked_checkboxes	=	$('#trainingbatch_grid input:checkbox:not(:checked)').val();
					alert('unchecked_checkboxes: '+unchecked_checkboxes);
					var str_searchIDs_new_uncheck	=	$('#porectraining-porec_id').val();
					var hiddenrecruitment_id_exist	=	$('#porectraining-porec_id').val();
					alert('str_searchIDs_new: '+str_searchIDs_new_uncheck);
					alert('hiddenrecruitment_id_exist: '+hiddenrecruitment_id_exist);*/					
					
					$('#porectraining-recruitment_id').val('');
					//$('#trainingbatch_grid').html('');					
				  }
				});
				
				/*$('.recruitmentcheckbox').click(function(){
					
					var selectedCheckboxval	=	$(this).val();
					//alert('selectedCheckboxval: '+selectedCheckboxval);
					if($('.recruitmentcheckbox').prop('checked') == true){
						var hiddenrecruitment_id_exist_ind		=	$('#porectraining-recruitment_id').val();
												
						if(hiddenrecruitment_id_exist_ind != ''){
							var str_searchIDs_ind				=	hiddenrecruitment_id_exist_ind + ',' + selectedCheckboxval;
						}
					
						else{
							var str_searchIDs_ind				=	selectedCheckboxval;
						}						
						
						$('#porectraining-recruitment_id').val(str_searchIDs_ind);
						$.post('ajax-appendtraining',{'recId':str_searchIDs_ind},function(datares){	
							$('#trainingbatch_grid').html(datares).show();
							//alert(response);
							//$('#recruitmentbatch_grid').show();
						})
					}
					if($('.recruitmentcheckbox').prop('checked') == false){
						
						//var rec_unckeckval		=	$(this).val() + ',';
						
						//alert(rec_unckeckval);
						var hiddenrecruitment_id_exist_uc		=	$('#porectraining-recruitment_id').val();
						
						if(!($(this).is(':checked'))){
							var rec_unckeckval		=	$(this).val();
							//REMOVE UNCHECKED CHECKBOX VALUE FROM HIDDEN FIELD
							var filtval =	hiddenrecruitment_id_exist_uc.replace(rec_unckeckval, '');
						}else{
							var filtval	=	hiddenrecruitment_id_exist_uc;
						}
						//alert('filtval: '+filtval);
						$('#porectraining-recruitment_id').val(filtval);
						$.post('ajax-appendtraining',{'recId':filtval},function(datares){	
							$('#trainingbatch_grid').html(datares).show();
							//alert(response);
							//$('#recruitmentbatch_grid').show();
						})
					}
				});	*/			
			});			
		</script>";		
	}
	
	public function actionOfferletter(){
		$model = new Recruitment();
		return $this->render('_formofferletter', [
            'model' => $model,
        ]);
	}
	
	public function actionStaffofferletter(){
		$model = new Recruitment();
		return $this->render('_formstaffofferletter', [
            'model' => $model,
        ]);
	}
	
	public function actionAjaxOfferletterselection(){
		ob_start();		
		$recModel = new OffeletterrSearch();
		$data = Yii::$app->request->post();				
		
		
		#$query = Recruitment::find()->where(['batch_id'=>$data['batch_id'],'training_status'=>'selected'])->all();
		$query = Recruitment::find()->where(['training_batch_id'=>$data['batch_id'],'training_status'=>'selected'])->all();
		
		
		echo '<input type="hidden" name="offer_date" id="offer_date" value="'.$data['offer_date'].'">';
		echo '<table> <th> Select</th> <th> Name </th> ';
		foreach($query as $res){						
			echo '<tr>
				<td><input type="checkbox" name="offerletter" id="offerletter_'.$res->id.'" class="offerletter" value='.$res->id.'></td>
				<td>'.$res->name.'</td>
			  </tr>';			
		}		
		
		echo '</table>';
		
		echo '<div id="offerletter_content">		
		</div>';
				
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				$('.offerletter').click(function() {
					$('input.offerletter').not(this).prop('checked', false);
					var rec_id		=	$(this).val();
					var offer_date	=	$('#offer_date').val();
					
					//alert('offer_date: '+offer_date);
					//alert('rec_id: '+rec_id);
					$('#offerletter_content').html('<center>loading...</center>');
					$.post('ajax-getofferlettercontent',{'rec_id':rec_id,'offer_date':offer_date},function(output){
						//alert('output: '+output);
						$('#offerletter_grid').show();	
						//$('#porectraining-offerletter').val(output);
						//CKEDITOR.instances.porectraining-offerletter.setData(output);
						//var editor = CKEDITOR.replace(output);
						//$('#offerletter').text(output);
						$('#offerletter_content').html(output);
						$('#recruitment_id').val(rec_id);
					})
				});
												
				$('.recruitmentcheckbox').click(function() {
					if($('.recruitmentcheckbox').prop('checked') == true){
						$('input.recruitmentcheckbox').not(this).prop('checked', false); 						
						var trainingid	=	$('input:checkbox[class=recruitmentcheckbox]:checked').val();
						//alert('trainingid: '+trainingid);
						$.post('porec-training/ajax-getofferlettercontent',{'training_id':trainingid},function(output){
							alert('output: '+output);
							$('#offerletter_grid').show();							
						})												
					}
				});
			});
		</script>";					
	}
	
	public function actionAjaxStaffofferletterselection(){
		
		ob_start();		
		$recModel = new OffeletterrSearch();
		$data = Yii::$app->request->post();				
		
		
		#$query = Recruitment::find()->where(['batch_id'=>$data['batch_id'],'training_status'=>'selected'])->all();
		$query = Recruitment::find()->where(['type'=>'staff','offerletter_status'=>'0','status'=>'selected'])->all();
		
		
		echo '<input type="hidden" name="offer_date" id="offer_date" value="'.$data['offer_date'].'">';
		echo '<table> <th> Select</th> <th> Name </th> ';
		foreach($query as $res){						
			echo '<tr>
				<td><input type="checkbox" name="offerletter" id="offerletter_'.$res->id.'" class="offerletter" value='.$res->id.'></td>
				<td>'.$res->name.'</td>
			  </tr>';			
		}		
		
		echo '</table>';
		
		echo '<div id="offerletter_content">		
		</div>';
		
		
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				$('.offerletter').click(function() {
					$('input.offerletter').not(this).prop('checked', false);
					var rec_id		=	$(this).val();
					var offer_date	=	$('#offer_date').val();
					
					//alert('offer_date: '+offer_date);
					//alert('rec_id: '+rec_id);
					$('#offerletter_content').html('<center>loading...</center>');
					$.post('ajax-getofferlettercontent',{'rec_id':rec_id,'offer_date':offer_date},function(output){
						//alert('output: '+output);
						$('#offerletter_grid').show();	
						//$('#porectraining-offerletter').val(output);
						//CKEDITOR.instances.porectraining-offerletter.setData(output);
						//var editor = CKEDITOR.replace(output);
						//$('#offerletter').text(output);
						$('#offerletter_content').html(output);
						$('#recruitment_id').val(rec_id);
					})
				});
												
				$('.recruitmentcheckbox').click(function() {
					if($('.recruitmentcheckbox').prop('checked') == true){
						$('input.recruitmentcheckbox').not(this).prop('checked', false); 						
						var trainingid	=	$('input:checkbox[class=recruitmentcheckbox]:checked').val();
						//alert('trainingid: '+trainingid);
						$.post('porec-training/ajax-getofferlettercontent',{'training_id':trainingid},function(output){
							alert('output: '+output);
							$('#offerletter_grid').show();							
						})												
					}
				});
			});
		</script>";					
	}
	
	public function actionAjaxBulkofferletterselection(){
		ob_start();		
		$recModel = new OffeletterrSearch();
		$data = Yii::$app->request->post();			
		
		#$query = Recruitment::find()->where(['batch_id'=>$data['batch_id'],'process_status'=>'selected'])->all();		
		$query = Recruitment::find()->where(['training_batch_id'=>$data['batch_id'],'training_status'=>'selected'])->all();		
		echo '<table> <th> <input type="checkbox" name="bulkmail" id="bulkmail" class="bulkmail" value="Check/Uncheck All" /></th> <th> Name </th> ';
		foreach($query as $res){			
			echo '<tr>
			<td><input type="checkbox" name="offerletter_bulk[]" id="offerletter_bulk_'.$res->id.'" class="offerletter_bulk" value='.$res->id.'></td>
			<td>'.$res->name.'</td>
		  </tr>';
		}
		
		echo '</table>';
		echo '</br>';
		echo '<button type="submit" class="btn-sm btn-success" id="send_offer" value="Send Bulk Offerletter">Send Bulk Offerletter</button>';
				
		echo "<script type='text/javascript'>
			$('document').ready(function(){				
				$('#bulkmail').click(function() {
					//alert('hi');
					if ($('#bulkmail').prop('checked') == true) {
						$('.offerletter_bulk').prop('checked', true);
						$('#bulkmail').attr('checked', false);
					} else {
						$('.offerletter_bulk').prop('checked', false);
						$('#bulkmail').attr('checked', 'true');
					}
				})
				
				
				
				$('.offerletter').click(function() {
					$('input.offerletter').not(this).prop('checked', false);
					var rec_id	=	$(this).val();
					alert('rec_id: '+rec_id);
					$.post('ajax-getofferlettercontent',{'rec_id':rec_id},function(output){
						alert('output: '+output);
						$('#offerletter_grid').show();	
						//$('#porectraining-offerletter').val(output);
						//CKEDITOR.instances.porectraining-offerletter.setData(output);
						//var editor = CKEDITOR.replace(output);
						//$('#offerletter').text(output);
						$('#offerletter_content').html(output);
						$('#recruitment_id').val(rec_id);
					})
				});
				
				$('.recruitmentcheckbox').click(function() {
					if($('.recruitmentcheckbox').prop('checked') == true){
						$('input.recruitmentcheckbox').not(this).prop('checked', false); 						
						var trainingid	=	$('input:checkbox[class=recruitmentcheckbox]:checked').val();
						//alert('trainingid: '+trainingid);
						$.post('ajax-getofferlettercontent',{'training_id':trainingid},function(output){
							alert('output: '+output);
							$('#offerletter_grid').show();							
						})												
					}
				});
			});
		</script>";					
	}
	
	public function actionAjaxStaffbulkofferletterselection(){
		ob_start();		
		$recModel = new OffeletterrSearch();
		$data = Yii::$app->request->post();			
		
		#$query = Recruitment::find()->where(['batch_id'=>$data['batch_id'],'process_status'=>'selected'])->all();		
		#$query = Recruitment::find()->where(['training_batch_id'=>$data['batch_id'],'training_status'=>'selected'])->all();		
		$query = Recruitment::find()->where(['type'=>'staff','offerletter_status'=>'0','status'=>'selected'])->all();
		echo '<table> <th> <input type="checkbox" name="bulkmail" id="bulkmail" class="bulkmail" value="Check/Uncheck All" /></th> <th> Name </th> ';
		foreach($query as $res){			
			echo '<tr>
			<td><input type="checkbox" name="offerletter_bulk[]" id="offerletter_bulk_'.$res->id.'" class="offerletter_bulk" value='.$res->id.'></td>
			<td>'.$res->name.'</td>
		  </tr>';
		}
		
		echo '</table>';
		echo '</br>';
		echo '<button type="submit" class="btn-sm btn-success" id="send_offer" value="Send Bulk Offerletter">Send Bulk Offerletter</button>';
				
		echo "<script type='text/javascript'>
			$('document').ready(function(){				
				$('#bulkmail').click(function() {
					//alert('hi');
					if ($('#bulkmail').prop('checked') == true) {
						$('.offerletter_bulk').prop('checked', true);
						$('#bulkmail').attr('checked', false);
					} else {
						$('.offerletter_bulk').prop('checked', false);
						$('#bulkmail').attr('checked', 'true');
					}
				})
				
				$('.offerletter').click(function() {
					$('input.offerletter').not(this).prop('checked', false);
					var rec_id	=	$(this).val();
					alert('rec_id: '+rec_id);
					$.post('ajax-getofferlettercontent',{'rec_id':rec_id},function(output){
						alert('output: '+output);
						$('#offerletter_grid').show();	
						//$('#porectraining-offerletter').val(output);
						//CKEDITOR.instances.porectraining-offerletter.setData(output);
						//var editor = CKEDITOR.replace(output);
						//$('#offerletter').text(output);
						$('#offerletter_content').html(output);
						$('#recruitment_id').val(rec_id);
					})
				});
				
				$('.recruitmentcheckbox').click(function() {
					if($('.recruitmentcheckbox').prop('checked') == true){
						$('input.recruitmentcheckbox').not(this).prop('checked', false); 						
						var trainingid	=	$('input:checkbox[class=recruitmentcheckbox]:checked').val();
						//alert('trainingid: '+trainingid);
						$.post('ajax-getofferlettercontent',{'training_id':trainingid},function(output){
							alert('output: '+output);
							$('#offerletter_grid').show();							
						})												
					}
				});
			});
		</script>";					
	}
	
	public function actionAjaxGetofferlettercontent(){
		ob_start();
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		$model			=	new Recruitment();
		$query  		= 	Recruitment::find()->where(['id'=>$_POST['rec_id']])->one();
		$offerquery		=	Recruitment::find()->where(['offerletter_status'=>'1'])->all();
		#$offercount_val	=	count($offerquery);
		$offercount_val	=	0;
		$autogen_offerno	=	'';
		foreach($offerquery as $resoffer){
			$offercount_val++;
		}
		
		if (!empty($offercount_val)) {					
				$result = strlen($offercount_val);
				 $offercount_valnxt	=	 $offercount_val+1;
				if ($result == 1) {
					$autogen_offerno	=	trim('000' . $offercount_valnxt);
				} elseif ($result == 2) {
					$autogen_offerno	= trim('00' . $offercount_valnxt);
				} elseif ($result == 3) {
					$autogen_offerno	= trim('0' . $offercount_valnxt);
				} elseif ($result == 4) {
					$autogen_offerno	= trim($offercount_valnxt);
				}			
		} else {
			$autogen_offerno	= trim('0001');
		}
		
		
		#echo $query->createCommand()->getRawSql();	
		#echo "<pre>";print_r($offerquery);echo "</pre>";	
		$offer_date_reverse	=	date('Ymd',strtotime($_POST['offer_date']));
		
		$this->layout 	=	'offerletter';
		$pomodel		=	new PorecTraining();	
			
			
				
		/*$pomodel->offerletter	=	"<p align='center'><strong>OFFER LETTER</strong></p>
										<p>Ref: VEPL/HR-Offer/".$offer_date_reverse."/183219 .</p>
										<p>Date: ".date('d.m.Y',strtotime($_POST['offer_date'])).".</p>
										<p>&nbsp;</p>
										<p>To,</p>
										<p><strong>".$query->name."</strong>.</p>										
										<p><strong>&nbsp;</strong></p>
										<p>Dear ".$query->name."</p>
										<p>&nbsp;</p>
										<p><strong>Sub: Offer letter for employment</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p>With reference to your application for a career in our organization and subsequent to the discussions we had, we are pleased to offer you employment in our Organization as</p>
										<p><strong>".$query->position."</strong>.</p>
										<p>&nbsp;</p>
										<p>We look forward to you joining us and expect your efforts to play a key in achieving VEPL's goals. We are confident that we will be able to present you with an exciting and challenging career with commensurate rewards.</p>
										<p>&nbsp;</p>
										<p>Your Annual Cost to the Company <strong>(CTC)</strong> will be as discussed and agreed by you. Your compensation is a confidential matter between you and the company and you are expected to maintain secrecy of the same. The breakup of the salary will be issued to you at the time of joining.</p>
										<p>&nbsp;</p>
										<p>If you are a trainee, you will be on training for a period of one year post which you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
										<p>&nbsp;</p>
										<p>If you are not a trainee, you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
										<p>&nbsp;</p>
										<p>This offer of employment is subject to verification of your academic &amp; technical qualifications and professional experience. In case it is found that you have disclosed wrong information on any of the above the Company has the right to withdraw the offer immediately without any notice.</p>
										<p>&nbsp;</p>
										<p>Your employment is also subject to you being declared medically fit by the Company Approved Medical Practitioner. This offer stands withdrawn if you have been declared</p>
										<p>medically unfit by the Medical Practitioner.</p>
										<p>Your employment with us will be governed by the Terms &amp; Conditions as detailed in Appointment letter which will be issued to you after your complete documentary procedures.</p>
										<p>&nbsp;</p>
										<p>We look forward to you joining us on or before XXXX  failing which this offer stands</p>
										<p>cancelled.</p>
										<p>&nbsp;</p>
										<p>Please note that you are expected to submit the following documents at the time of joining as part of HR Process:</p>
										<p>&nbsp;</p>
										<ol>
										<li>Relieving Order / Experience Certificates from all previous organization you have worked.</li>
										<li>Copy of last drawn salary slip / salary certificate from your previous organization.</li>
										<li>Copy of your all Educational Certificates.</li>
										<li>Certificate in support of your Date of Birth.</li>
										<li>Six Passport Size photographs.</li>
										<li>Copy of PAN Card / Aadhar card / Passport / Voter ID / Ration card / Driving license.</li>
										<li>IT Computation from Previous Employer if you join in middle of the financial year.</li>
										<li>Proof of your Address and Identify (Copy of Ration Card / Passport / Driving license / Voter Id etc.)</li>
										<li>Original certificates of the above to be presented for verification.</li>
										</ol>
										<p>&nbsp;</p>
										<p>On submission of the above-mentioned documents and subsequent to you joining us, your appointment letter will be issued.</p>
										<p>&nbsp;</p>
										<p>Company is not responsible for any offers made orally. It is valid only if given in writing. The Offer Letter is enclosed in duplicate. You are requested to print this offer letter copy, sign it, scan and send the same to pr@voltechgroup.com confirming your acceptance of terms and conditions</p>
										<p>&nbsp;</p>
										<p>Please follow the instructions as mentioned in the mail.</p>
										<p>&nbsp;</p>
										<p>Cordially,</p>
										<p>&nbsp;</p>
										<p>For <strong>VOLTECH Engineers Private Limited</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p><strong>KUMARESAN.E</strong></p>
										<p><strong>AGM &ndash; HR &amp; IR</strong></p>
										<p>&nbsp;</p>
										<p>I have read, understood and accept the above terms and conditions of employment. As</p>
										<p>desired, I shall join service on or before XXXXX.</p>
										<p>&nbsp;</p>
										<p><strong>Note:</strong> On failure of your reporting to duty as per offer acceptance, you will not be considered for any future requirements in Voltech Group</p>
										<p>.</p>
										<p>Name: </p>
										<p>Signature</p>
										<p>Date</p>";*/
										
		$pomodel->offerletter	= "<p>&nbsp;</p>
						<p><center><strong>OFFER LETTER</strong></center></p>
						<p><strong>&nbsp;</strong></p>
						<p>Ref: VEPL/Offer/".$offer_date_reverse."/".$autogen_offerno."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						Date: ".date('d.m.Y',strtotime($_POST['offer_date']))."</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>Dear $query->name,</p>
						<p>&nbsp;</p>
						<p><strong>Sub: Offer letter for employment</strong></p>
						<p><strong>&nbsp;</strong></p>
						<p>With reference to your application for a career in our organization and subsequent to the discussions we had, we are pleased to offer you employment in our Organization as <strong>$query->position, WL 5B</strong>.</p>
						<p>&nbsp;</p>
						<p>We look forward to you joining us and expect your efforts to play a key in achieving VEPL's goals. We are confident that we will be able to present you with an exciting and challenging career with commensurate rewards.</p>
						<p>&nbsp;</p>
						<p>Your Annual Cost to the Company <strong>(CTC) </strong>will be as discussed and agreed by you. Your compensation is a confidential matter between you and the company and you are expected to maintain secrecy of the same. The breakup of the salary will be issued to you at the time of joining.</p>
						<p>&nbsp;</p>
						<p>If you are a trainee, you will be under &lsquo;On the job training&rsquo; for a period of Six Months post which you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
						<p>&nbsp;</p>
						<p>If you are not a trainee, you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
						<p>&nbsp;</p>
						<p>This offer of employment is subject to verification of your academic &amp; technical qualifications and professional experience. In case it is found that you have disclosed wrong information on any of the above the Company has the right to withdraw the offer immediately without any notice.</p>
						<p>&nbsp;</p>
						<p>Your employment is also subject to you being declared medically fit by the Company Approved Medical Practitioner. This offer stands withdrawn if you have been declared medically unfit by the Medical Practitioner.</p>
						<p>&nbsp;</p>
						<p>Your employment with us will be governed by the Terms &amp; Conditions as detailed in Appointment letter which will be issued to you after your complete documentary procedures. We look forward to call you for joining us on any day before 60 days from the date of Offer refusing which this offer stands cancelled.</p>
						<p>&nbsp;</p>
						<p>Please note that you are expected to submit the following documents at the time of joining as part of HR Process:</p>
						<p>&nbsp;</p>
						<ol>
						<li>Relieving Order / Experience Certificates from all previous organization you have</li>
						<li>Filled, Signed and Notarized Service</li>
						<li>Copy of last drawn salary slip / salary certificate from your previous</li>
						<li>Copy of your all Educational</li>
						<li>Certificate in support of your Date of</li>
						<li>Ten Passport Size</li>
						<li>Copy of PAN Card / Aadhar card / Passport / Voter ID / Ration card / Driving</li>
						<li>Police Verification / Clearance</li>
						<li>Proof of your Address and Identify (Copy of Ration Card / Passport / Driving license / Voter Id etc.)</li>						
						</ol>
						<ol start='10'>
						<li>Original certificates of the above to be presented for</li>
						</ol>
						<p>&nbsp;</p>
						<p>On submission of the above-mentioned documents and subsequent to you joining us, your appointment letter will be issued.</p>
						<p>&nbsp;</p>
						<p>Company is not responsible for any offers made orally. It is valid only if given in writing. The Offer Letter is enclosed in duplicate. You are requested to print this offer letter copy, sign it, scan and send the same to <a href='mailto:pr@voltechgroup.com'>pr@voltechgroup.com</a> confirming your acceptance of terms and conditions</p>
						<p>&nbsp;</p>
						<p>Please follow the instructions as mentioned in the mail. For <strong>VOLTECH Engineers Private Limited</strong></p>
						<p><strong>&nbsp;</strong></p>
						<p><strong>Kumaresan.E</strong></p>
						<p><strong>AGM &ndash; HR &amp; IR</strong>&nbsp;</p>";
										
		#$pomodel->offerletter	=	"";
										
							
		#exit;
		echo $this->render('offerletter_content', [ 'model' => $pomodel, ]);
	}	

	public function actionSendofferletter()
    { 
		$model = new MailForm();
		$porecModel	=	new PorecTraining();
		#$data = Yii::$app->request->post();	 
		if (isset($_POST)) {
			#echo "<pre>";print_r(Yii::$app->request->post());echo "</pre>";		
			
			$recModel		=	Recruitment::findOne($_POST['recruitment_id']);
			$toMail			=	$recModel->email;
			$model->body	=	$_POST['PorecTraining']['offerletter'];
			$model->subject	=	'Offer Letter';
			#echo "</br> toMail: ".$toMail;
			#exit;
		   #$Salmodel = EmpSalary::findOne($id);
		   #$ModelEmp = EmpDetails::find()->where(['id'=>$Salmodel->empid])->one();
			$model->from = "pr@voltechgroup.com";
			$model->password = "Vepl@4321";
			$model->fromName = 'OFFER LETTER';
				if ($model->sendEmail($toMail)) {
					Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
					$porecModel->offerletter_status =1;
					$porecModel->save(false);
				} else {
					Yii::$app->session->setFlash('error', 'There was an error sending your message.');
				} 
			  return $this->redirect('offerletter');   
		}
		 return $this->redirect('offerletter');   	
	}

	public function actionSendbulkofferletter()
    { 	
		$model = new MailForm(); 
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		
		$offerdate_day		=	date('d',strtotime($_POST['Recruitment']['offer_date']));
		$offerdate_month	=	date('M',strtotime($_POST['Recruitment']['offer_date']));
		$offerdate_year		=	date('Y',strtotime($_POST['Recruitment']['offer_date']));
		
		$offer_date_reverse	=	date('Ymd',strtotime($_POST['Recruitment']['offer_date']));
		
		$offerquery		=	Recruitment::find()->where(['offerletter_status'=>'1'])->all();
		$offercount_val	=	0;
		$autogen_offerno	=	'';
		foreach($offerquery as $resoffer){
			$offercount_val++;
		}
		
		if (!empty($offercount_val)) {					
				$result = strlen($offercount_val);
				 $offercount_valnxt	=	 $offercount_val+1;
				if ($result == 1) {
					$autogen_offerno	=	trim('000' . $offercount_valnxt);
				} elseif ($result == 2) {
					$autogen_offerno	= trim('00' . $offercount_valnxt);
				} elseif ($result == 3) {
					$autogen_offerno	= trim('0' . $offercount_valnxt);
				} elseif ($result == 4) {
					$autogen_offerno	= trim($offercount_valnxt);
				}			
		} else {
			$autogen_offerno	= trim('0001');
		}
		
				foreach($_POST['offerletter_bulk'] as $bulkOffer){	
				
				$ModelRec = Recruitment::find()->where(['id'=>$bulkOffer])->one();				
				$model->from = "pr@voltechgroup.com";
				$model->password = "Vepl@4321";
				$model->fromName = 'OFFER LETTER';
				$model->subject = 'Offer Letter'; 
				$model->email = $ModelRec->email; 
				
				
				

				/*$model->body = "<p align='center'><strong>OFFER LETTER</strong></p>
										<p>Ref: VEPL/HR-Offer/".$offer_date_reverse."/183219 .</p>
										<p>Date: ".date('d.m.Y',strtotime($_POST['Recruitment']['offer_date'])).".</p>
										<p>&nbsp;</p>
										<p>To,</p>
										<p><strong>".$ModelRec->name."</strong>.</p>										
										<p><strong>&nbsp;</strong></p>
										<p>Dear ".$ModelRec->name."</p>
										<p>&nbsp;</p>
										<p><strong>Sub: Offer letter for employment</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p>With reference to your application for a career in our organization and subsequent to the discussions we had, we are pleased to offer you employment in our Organization as</p>
										<p><strong>".$ModelRec->position."</strong>.</p>
										<p>&nbsp;</p>
										<p>We look forward to you joining us and expect your efforts to play a key in achieving VEPL's goals. We are confident that we will be able to present you with an exciting and challenging career with commensurate rewards.</p>
										<p>&nbsp;</p>
										<p>Your Annual Cost to the Company <strong>(CTC)</strong> will be as discussed and agreed by you. Your compensation is a confidential matter between you and the company and you are expected to maintain secrecy of the same. The breakup of the salary will be issued to you at the time of joining.</p>
										<p>&nbsp;</p>
										<p>If you are a trainee, you will be on training for a period of one year post which you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
										<p>&nbsp;</p>
										<p>If you are not a trainee, you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
										<p>&nbsp;</p>
										<p>This offer of employment is subject to verification of your academic &amp; technical qualifications and professional experience. In case it is found that you have disclosed wrong information on any of the above the Company has the right to withdraw the offer immediately without any notice.</p>
										<p>&nbsp;</p>
										<p>Your employment is also subject to you being declared medically fit by the Company Approved Medical Practitioner. This offer stands withdrawn if you have been declared</p>
										<p>medically unfit by the Medical Practitioner.</p>
										<p>Your employment with us will be governed by the Terms &amp; Conditions as detailed in Appointment letter which will be issued to you after your complete documentary procedures.</p>
										<p>&nbsp;</p>
										<p>We look forward to you joining us on or before ".date('d.m.Y',strtotime($_POST['Recruitment']['offer_date']))."  failing which this offer stands</p>
										<p>cancelled.</p>
										<p>&nbsp;</p>
										<p>Please note that you are expected to submit the following documents at the time of joining as part of HR Process:</p>
										<p>&nbsp;</p>
										<ol>
										<li>Relieving Order / Experience Certificates from all previous organization you have worked.</li>
										<li>Copy of last drawn salary slip / salary certificate from your previous organization.</li>
										<li>Copy of your all Educational Certificates.</li>
										<li>Certificate in support of your Date of Birth.</li>
										<li>Six Passport Size photographs.</li>
										<li>Copy of PAN Card / Aadhar card / Passport / Voter ID / Ration card / Driving license.</li>
										<li>IT Computation from Previous Employer if you join in middle of the financial year.</li>
										<li>Proof of your Address and Identify (Copy of Ration Card / Passport / Driving license / Voter Id etc.)</li>
										<li>Original certificates of the above to be presented for verification.</li>
										</ol>
										<p>&nbsp;</p>
										<p>On submission of the above-mentioned documents and subsequent to you joining us, your appointment letter will be issued.</p>
										<p>&nbsp;</p>
										<p>Company is not responsible for any offers made orally. It is valid only if given in writing. The Offer Letter is enclosed in duplicate. You are requested to print this offer letter copy, sign it, scan and send the same to pr@voltechgroup.com confirming your acceptance of terms and conditions</p>
										<p>&nbsp;</p>
										<p>Please follow the instructions as mentioned in the mail.</p>
										<p>&nbsp;</p>
										<p>Cordially,</p>
										<p>&nbsp;</p>
										<p>For <strong>VOLTECH Engineers Private Limited</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p><strong>&nbsp;</strong></p>
										<p><strong>KUMARESAN.E</strong></p>
										<p><strong>AGM &ndash; HR &amp; IR</strong></p>
										<p>&nbsp;</p>
										<p>I have read, understood and accept the above terms and conditions of employment. As</p>
										<p>desired, I shall join service on or before XXXXX.</p>
										<p>&nbsp;</p>
										<p><strong>Note:</strong> On failure of your reporting to duty as per offer acceptance, you will not be considered for any future requirements in Voltech Group</p>
										<p>.</p>
										<p>Name: </p>
										<p>Signature</p>
										<p>Date</p>";*/
										
					$model->body ="<p>&nbsp;</p>
						<p><center><strong>OFFER LETTER</strong></center></p>
						<p><strong>&nbsp;</strong></p>
						<p>Ref: VEPL/Offer/".$offer_date_reverse."/".$autogen_offerno."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						Date: ".date('d.m.Y',strtotime($_POST['Recruitment']['offer_date']))."</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>Dear ".$ModelRec->name.",</p>
						<p>&nbsp;</p>
						<p><strong>Sub: Offer letter for employment</strong></p>
						<p><strong>&nbsp;</strong></p>
						<p>With reference to your application for a career in our organization and subsequent to the discussions we had, we are pleased to offer you employment in our Organization as <strong>".$ModelRec->position.", WL 5B</strong>.</p>
						<p>&nbsp;</p>
						<p>We look forward to you joining us and expect your efforts to play a key in achieving VEPL's goals. We are confident that we will be able to present you with an exciting and challenging career with commensurate rewards.</p>
						<p>&nbsp;</p>
						<p>Your Annual Cost to the Company <strong>(CTC) </strong>will be as discussed and agreed by you. Your compensation is a confidential matter between you and the company and you are expected to maintain secrecy of the same. The breakup of the salary will be issued to you at the time of joining.</p>
						<p>&nbsp;</p>
						<p>If you are a trainee, you will be under &lsquo;On the job training&rsquo; for a period of Six Months post which you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
						<p>&nbsp;</p>
						<p>If you are not a trainee, you will be on probation for a period of Six months and based on your performance your services will be confirmed with us in writing. The company reserves the right to reduce / dispense with or extend your probation period at its sole discretion.</p>
						<p>&nbsp;</p>
						<p>This offer of employment is subject to verification of your academic &amp; technical qualifications and professional experience. In case it is found that you have disclosed wrong information on any of the above the Company has the right to withdraw the offer immediately without any notice.</p>
						<p>&nbsp;</p>
						<p>Your employment is also subject to you being declared medically fit by the Company Approved Medical Practitioner. This offer stands withdrawn if you have been declared medically unfit by the Medical Practitioner.</p>
						<p>&nbsp;</p>
						<p>Your employment with us will be governed by the Terms &amp; Conditions as detailed in Appointment letter which will be issued to you after your complete documentary procedures. We look forward to call you for joining us on any day before 60 days from the date of Offer refusing which this offer stands cancelled.</p>
						<p>&nbsp;</p>
						<p>Please note that you are expected to submit the following documents at the time of joining as part of HR Process:</p>
						<p>&nbsp;</p>
						<ol>
						<li>Relieving Order / Experience Certificates from all previous organization you have</li>
						<li>Filled, Signed and Notarized Service</li>
						<li>Copy of last drawn salary slip / salary certificate from your previous</li>
						<li>Copy of your all Educational</li>
						<li>Certificate in support of your Date of</li>
						<li>Ten Passport Size</li>
						<li>Copy of PAN Card / Aadhar card / Passport / Voter ID / Ration card / Driving</li>
						<li>Police Verification / Clearance</li>
						<li>Proof of your Address and Identify (Copy of Ration Card / Passport / Driving license / Voter Id etc.)</li>
						</ol>
						
						<ol start='10'>
						<li>Original certificates of the above to be presented for</li>
						</ol>
						<p>&nbsp;</p>
						<p>On submission of the above-mentioned documents and subsequent to you joining us, your appointment letter will be issued.</p>
						<p>&nbsp;</p>
						<p>Company is not responsible for any offers made orally. It is valid only if given in writing. The Offer Letter is enclosed in duplicate. You are requested to print this offer letter copy, sign it, scan and send the same to <a href='mailto:pr@voltechgroup.com'>pr@voltechgroup.com</a> confirming your acceptance of terms and conditions</p>
						<p>&nbsp;</p>
						<p>Please follow the instructions as mentioned in the mail. For <strong>VOLTECH Engineers Private Limited</strong></p>
						<p><strong>&nbsp;</strong></p>
						<p><strong>Kumaresan.E</strong></p>
						<p><strong>AGM &ndash; HR &amp; IR</strong>&nbsp;</p>";
				
					if ($model->sendEmail($ModelRec->email)) {
						Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
						$ModelRec->offerletter_status =1;
						$ModelRec->offer_date = date('Y-m-d',strtotime($_POST['Recruitment']['offer_date']));
						$ModelRec->save(false);
					} else {
						Yii::$app->session->setFlash('error', 'There was an error sending your message.');
					} 					  
			   } 
		    return $this->redirect('offerletter');		
	}	
	
	/****************  Offer Letter Generate  *****************************/	

	############################### JOIN ##################################
	public function actionJoining(){
		$this->layout = 'main';
		$recModel = new Recruitment();				
		return $this->render('_formjoining', [
            'model' => $recModel,
        ]);
	}
	
	public function actionJoinprocess(){
		$model	=	new Recruitment;
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		if(isset($_POST['recruitmentjoin']) ) {
			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$recsel	=	$_POST['join'];
			foreach($recsel as $res){
				$recModel							=	Recruitment::findOne($res);	
				$recModel->join_status				=	$_POST['Recruitment']['join_status'];
				#$recModel->process_statusremarks	=	$_POST['process_statusremarks'];
				$recModel->save(false);
			}			
		}
		
		return $this->render('_formjoining', [
            'model' => $model,
        ]);
	}
	
	public function actionJoiningecode(){
		$recModel = new Recruitment();
				
		return $this->render('_formjoiningecode', [
            'model' => $recModel,
        ]);
	}
	
	public function actionAssignecode(){
		$recModel = new Recruitment();
		$i	=	0;
		if(isset($_POST['ecode_join'])){
			foreach($_POST['recid'] as $recr_id){				
					#$RecModel = Recruitment::find()->where(['id'=>$bulkOffer])->one();
					$model = $this->findRecruitmentModel($recr_id);			
								
					$model->ecode				=	$_POST['ecode'][$i];
					$model->save(false);	
					$i++;				
					#exit;			
					Yii::$app->session->setFlash('success', 'Ecode Successfully Saved. ');
			}
		}
		
		return $this->redirect(['joiningecode', 'model' => $recModel]);
	}
	############################### JOIN ##################################
	
	
    /**
     * Finds the PorecTraining model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PorecTraining the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PorecTraining::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findRecruitmentModel($id)
    {
        if (($model = Recruitment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}