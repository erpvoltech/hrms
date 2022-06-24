<?php
namespace frontend\controllers;

use Yii;
use app\models\PorecTraining;
use app\models\TrainingTopics;
use app\models\PorecTrainingAttendance;
use app\models\PorecTrainingAttendanceExisting;
use app\models\Recruitment;
use app\models\PorecTrainingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\EmpDetails;

use yii\helpers\Url;
/**
 * PostrectrainingController implements the CRUD actions for PorecTraining model.
 */
class PostrectrainingController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PorecTraining models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new PorecTraining();
		
		return $this->render('index', [
				'model' => $model,
			]);
        #$searchModel = new PorecTrainingSearch();				
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			/*return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);*/				
    }
	
	public function actionAttendance()
    {
		$model = new PorecTraining();
		
		return $this->render('training_attendance', [
				'model' => $model,
			]);       		
    }
	
	public function actionAttendanceExisting()
    {
		$model = new PorecTraining();
		
		return $this->render('training_attendance_existing', [
				'model' => $model,
			]);       		
    }
	
	public function actionAttendancereport()
    {
		$model = new PorecTraining();
		
		return $this->render('attendance_report', [
				'model' => $model,
		]);      				
    }
	
	public function actionAttendancereportExisting()
    {
		$model = new PorecTraining();
		
		return $this->render('attendance_report_existing', [
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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
	
	
	################# New Training Selection ######################
	public function actionAjaxTrainingselection(){
		#echo "hi";
		#exit;
		ob_start();
		#$recModel = new TrainingBatchSearch();
		$data = Yii::$app->request->post();
		$recruitment_arr	=	[];	
		#$dataProvider = $recModel->search('RecruitmentbatchSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentbatchSearch%5Bstatus%5D=selected');$dataProvider = $recModel->search('RecruitmentSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentSearch%5Bstatus%5D=selected');
		
		$trainigqry		=	PorecTraining::find()->where(['training_batch_id'=>$data['training_batch_id'],'training_type' => 'new'])->all();
		#echo "<pre>";print_r($trainigqry);echo "</pre>";
		#exit;
		if(count($trainigqry) > 0){
			echo "<input type='hidden' name='training_batch_id' id='training_batch_id' value='".$data['training_batch_id']."' />";
			echo "<input type='hidden' name='training_topic_id' id='training_topic_id' value='".$trainigqry[0]->trainig_topic_id."' />";
			echo "<input type='hidden' name='training_startdate' id='training_startdate' value='".$trainigqry[0]->training_startdate."' />";
			echo "<input type='hidden' name='training_enddate' id='training_enddate' value='".$trainigqry[0]->training_enddate."' />";
			#echo "<input type='hidden' name='' id='' value='' />";
			echo '<div class="form-group col-lg-4">Training Start Date: '.$trainigqry[0]->training_startdate.' </div>';
			echo '<div class="form-group col-lg-4">Training End Date: '.$trainigqry[0]->training_enddate.' </div>';
		}
		echo "<table class='table'>  <th>Name</th> <th><input type='checkbox' name='selection_all' class='select-on-check-all' id='selectall' value='1' ></th> ";
			$lp	=	0;
			foreach($trainigqry as $restraining){
				$recruitment_arr[$lp]['rec_id']			=	explode(',',$restraining->recruitment_id);
				$recruitment_arr[$lp]['training_id']	=	$restraining->id;
				$lp++;				
			}	
				#echo "<pre>";print_r($recruitment_arr);echo "</pre>";		
				
				for($i=0;$i<count($recruitment_arr);$i++){
					for($j=0;$j<count($recruitment_arr[$i]['rec_id']);$j++){
						
						if($recruitment_arr[$i]['rec_id'][$j] != ''){
							#echo "</br> recruitment_arr: ". $recruitment_arr[$i]['rec_id'][$j];
							$model	=	new Recruitment();
							if(is_numeric($recruitment_arr[$i]['rec_id'][$j])){
								#$recquery_rec = Recruitment::find()->where(['id'=>$recruitment_arr[$i]['rec_id'][$j],'training_status'=>'selected'])->one();
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
							
							if(isset($recname) && $recname != ''){
								echo '<tr>
										<td>'.$recname.'</td>		
										<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$recruitment_arr[$i]['rec_id'][$j].'></td>
										'.					
										#<td>'.$trngquery_rec->training_startdate.'</td>
										#<td>'.$trngquery_rec->training_enddate.'</td>									
									  '</tr>';
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
						} else{
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
							
			});			
		</script>";		
	}
	
	################# New Training Selection ######################
	
	################# Existing Training Selection ######################
	
	public function actionAjaxExistingtrainingselection(){
		ob_start();
		#$recModel = new TrainingBatchSearch();
		$data = Yii::$app->request->post();
		$ecode_arr	=	[];	
		#$dataProvider = $recModel->search('RecruitmentbatchSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentbatchSearch%5Bstatus%5D=selected');$dataProvider = $recModel->search('RecruitmentSearch%5Bbatch_id%5D='.$data['batch'].'&RecruitmentSearch%5Bstatus%5D=selected');
		#echo "hi";
		$trainigqry		=	PorecTraining::find()->where(['training_batch_id'=>$data['training_batch_id'],'training_type' => 'existing' ])->all();
		#echo "<pre>";print_r($trainigqry);echo "</pre>";
		#exit;
		if(count($trainigqry) > 0){
			echo "<input type='hidden' name='training_batch_id' id='training_batch_id' value='".$data['training_batch_id']."' />";
			echo "<input type='hidden' name='training_startdate' id='training_startdate' value='".$trainigqry[0]->training_startdate."' />";
			echo "<input type='hidden' name='training_enddate' id='training_enddate' value='".$trainigqry[0]->training_enddate."' />";
			#echo "<input type='hidden' name='' id='' value='' />";
			echo '<div class="form-group col-lg-4">Training Start Date: '.$trainigqry[0]->training_startdate.' </div>';
			echo '<div class="form-group col-lg-4">Training End Date: '.$trainigqry[0]->training_enddate.' </div>'; 
		}
		echo "<table class='table'>  <th>Name</th> <th><input type='checkbox' name='selection_all' class='select-on-check-all' id='selectall' value='1' ></th> ";
			$lp	=	0;
			foreach($trainigqry as $restraining){
				$ecode_arr[$lp]['ecode_id']			=	explode(',',$restraining->ecode);
				$ecode_arr[$lp]['training_id']		=	$restraining->id;
				$lp++;				
			}	
			#echo "<pre>";print_r($ecode_arr);echo "</pre>";		
				
				for($i=0;$i<count($ecode_arr);$i++){
					for($j=0;$j<count($ecode_arr[$i]['ecode_id']);$j++){
						
						if($ecode_arr[$i]['ecode_id'][$j] != ''){
							#echo "</br> ecode_arr: ". $ecode_arr[$i]['ecode_id'][$j];
							$model	=	new EmpDetails();
							if(is_numeric($ecode_arr[$i]['ecode_id'][$j])){
								#$recquery_rec = Recruitment::find()->where(['id'=>$recruitment_arr[$i]['rec_id'][$j],'training_status'=>'selected'])->one();
								$recquery_rec = EmpDetails::find()->where(['id'=>$ecode_arr[$i]['ecode_id'][$j]])->one();
								#echo "<pre>";print_r($recquery_rec);echo "</pre>";
								#exit;
								$ecodename	  	=	$recquery_rec['empname'];
							}else{								
								$ecodename		=	$ecode_arr[$i]['ecode_id'][$j];
							}
							$trngquery_rec = PorecTraining::find()->where(['id'=>$ecode_arr[$i]['training_id']])->one();							
							#echo $recquery_rec->createCommand()->getRawSql();
							#echo "<pre>";print_r($recquery_rec);echo "</pre>";
							#echo '<tr>								
									#<td><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$trngquery_rec->id.'></td>
							
							if(isset($ecodename) && $ecodename != ''){
								echo '<tr>
										<td>'.$ecodename.'</td>		
										<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="ecodecheckbox" value='.$ecode_arr[$i]['ecode_id'][$j].'></td>
										'.					
										#<td>'.$trngquery_rec->training_startdate.'</td>
										#<td>'.$trngquery_rec->training_enddate.'</td>									
									  '</tr>';
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
						} else{
							$('.recruitmentcheckbox').prop('checked', false);
							$('#selectall').attr('checked', 'true');
						}*/
						
						$('.ecodecheckbox').prop('checked', true);
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
					$('.ecodecheckbox').prop('checked', false);
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
			});			
		</script>";		
	}	
	################# Existing Training Selection ######################	
	
	##################### Attendance Report ############################
	public function actionAjaxTrainingselectionreport(){
		ob_start();
		#$recModel = new TrainingBatchSearch();
		$data = Yii::$app->request->post();
		$recruitment_arr	=	[];	
		
		$trainingtopics	=	TrainingTopics::find()->all();
		
		$trainigqry		=	PorecTraining::find()->where(['training_batch_id'=>$data['training_batch_id']])->all();
		#echo "<pre>";print_r($trainigqry);echo "</pre>";
		
		#exit;
		if(isset($trainigqry) && count($trainigqry) > 0 ){
		echo "<input type='hidden' name='training_batch_id' id='training_batch_id' value='".$data['training_batch_id']."' />";
		echo "<input type='hidden' name='training_startdate' id='training_startdate' value='".$trainigqry[0]->training_startdate."' />";
		echo "<input type='hidden' name='training_enddate' id='training_enddate' value='".$trainigqry[0]->training_enddate."' />";
		#echo "<input type='hidden' name='' id='' value='' />";
		echo '<div class="row"><div class="form-group col-lg-4">&nbsp;Training Start Date: '.$trainigqry[0]->training_startdate.' </div>';
		echo '<div class="form-group col-lg-4">Training End Date: '.$trainigqry[0]->training_enddate.' </div>';
		echo '<div class="form-group col-lg-4"> </div></div>';
		echo '<div class="row" style="overflow-x: auto;"><div class="panel"><div class="panel-body">';
		/*echo '<button id="export" class="btn btn-default"  title=Export Data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
			Export </button>';*/
		echo '<table class="table-bordered" style="font-size: 12px;"> <thead> <th>Name</th> ';
			foreach($trainingtopics as $restopics){
				echo "<th>".$restopics->topic_name."</th>";
			}
		echo "<th>Total Days</th></thead>";

			$lp	=	0;
			foreach($trainigqry as $restraining){
				$recruitment_arr[$lp]['rec_id']			=	explode(',',$restraining->recruitment_id);
				$recruitment_arr[$lp]['training_id']	=	$restraining->id;
				$lp++;				
			}	
				#echo "<pre>";print_r($recruitment_arr);echo "</pre>";		
				
				for($i=0;$i<count($recruitment_arr);$i++){
					for($j=0;$j<count($recruitment_arr[$i]['rec_id']);$j++){
						
						if($recruitment_arr[$i]['rec_id'][$j] != ''){
							$totaldays	=	0;
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
							#echo '<tbody style="overflow-x:auto; width:1200px; position:absolute>';
							if(isset($recname) && $recname != ''){
								echo '<tr>
										<td>'.$recname.'</td>';											
										foreach($trainingtopics as $restopics){			
											$topic_id=	$restopics->id;
											#$trg_attqry	= PorecTrainingAttendance::find->where(['training_batch_id'=>$data['training_batch_id'],'topic_id'=>$topic_id])->all();
											$trg_attqry = PorecTrainingAttendance::find()->where(['training_batch_id'=>$data['training_batch_id'],'topic_id'=>$topic_id])->one();
											#echo "<pre>";print_r($trg_attqry);echo "</pre>";
											$recid_str	=	$trg_attqry['recruitment_id'];
											$lprec_id	=	$recruitment_arr[$i]['rec_id'][$j];
											#echo "recid_str: ".$recid_str;
											$recid_arr	=	explode(',',$recid_str);
											if(in_array($lprec_id,$recid_arr)){
												$checkstatus	=	"CHECKED";
												$totaldays++;		
											}else{
												$checkstatus	=	"";
											}
											echo '<td align="center"><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$restopics->id.' '.$checkstatus.' onclick="return false"></td>';											
										}
										
										//<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$recruitment_arr[$i]['rec_id'][$j].'></td>
										echo '<td align="center">'.$totaldays.'</td>';								
								echo   '</tr>';
							}
							#echo '</tbody>';
							
						}
					}
				}
					
		echo "</table>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		}else{
			echo '<div class="row"><div class="panel"><div class="panel-body">';
			echo '<table class="table-bordered" style="font-size: 12px;"> <thead> <th>#</th> ';
			echo '<tr><td colspan="8">No Records Found</td></tr>';
			echo "</table>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}
		
		echo "<script type='text/javascript'>
			$('document').ready(function(){
				
				/*$('#export').click(function() {
					var training_batch	= $('#porectraining-training_batch_id').val();
					//alert('training_batch: '+training_batch);
					var printWindow = window.open('export?training_batch='+training_batch, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
					printWindow.document.title = 'Downloading';

									printWindow.addEventListener('load', function () {

									}, true);
				});*/
				
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
							
			});			
		</script>";		
	}
	
	public function actionExport() {
		#echo "hi";
		#exit;
		#$data['training_batch_id'] = $_GET['training_batch'];
      return $this->render('export');
	}
	
	##################### Existing Attendance Report ############################
	public function actionAjaxExistingtrainingselectionreport(){
		ob_start();
		#$recModel = new TrainingBatchSearch();
		$data = Yii::$app->request->post();
		$recruitment_arr	=	[];	
		
		$trainingtopics	=	TrainingTopics::find()->all();
		
		$trainigqry		=	PorecTraining::find()->where(['training_batch_id'=>$data['training_batch_id']])->all();
		#echo "<pre>";print_r($trainigqry);echo "</pre>";
		
		#exit;
		echo "<input type='hidden' name='training_batch_id' id='training_batch_id' value='".$data['training_batch_id']."' />";
		echo "<input type='hidden' name='training_startdate' id='training_startdate' value='".$trainigqry[0]->training_startdate."' />";
		echo "<input type='hidden' name='training_enddate' id='training_enddate' value='".$trainigqry[0]->training_enddate."' />";
		#echo "<input type='hidden' name='' id='' value='' />";
		echo '<div class="row"><div class="form-group col-lg-4">&nbsp;Training Start Date: '.$trainigqry[0]->training_startdate.' </div>';
		echo '<div class="form-group col-lg-4">Training End Date: '.$trainigqry[0]->training_enddate.' </div>';
		echo '<div class="form-group col-lg-4"> </div></div>';
		echo '<div class="row" style="overflow-x: auto;"><div class="panel"><div class="panel-body">';
		echo '<table class="table-bordered" style="font-size: 12px;"> <thead> <th>Name</th> ';
			foreach($trainingtopics as $restopics){
				echo "<th>".$restopics->topic_name."</th>";
			}
		echo "<th>Total Days</th></thead>";

			$lp	=	0;
			foreach($trainigqry as $restraining){
				$recruitment_arr[$lp]['ecode_id']			=	explode(',',$restraining->ecode);
				$recruitment_arr[$lp]['training_id']		=	$restraining->id;
				$lp++;				
			}	
				#echo "<pre>";print_r($recruitment_arr);echo "</pre>";		
				
				for($i=0;$i<count($recruitment_arr);$i++){
					for($j=0;$j<count($recruitment_arr[$i]['ecode_id']);$j++){
						
						if($recruitment_arr[$i]['ecode_id'][$j] != ''){
							$totaldays	=	0;
							#echo "</br> recruitment_arr: ". $recruitment_arr[$i]['ecode_id'][$j];
							$model	=	new EmpDetails();
							if(is_numeric($recruitment_arr[$i]['ecode_id'][$j])){
								$recquery_rec = EmpDetails::find()->where(['id'=>$recruitment_arr[$i]['ecode_id'][$j]])->one();
								#echo "<pre>";print_r($recquery_rec);echo "</pre>";
								#exit;
								$empname	  	=	$recquery_rec['empname'];
							}else{								
								$empname		=	$recruitment_arr[$i]['ecode_id'][$j];
							}
							$trngquery_rec = PorecTraining::find()->where(['id'=>$recruitment_arr[$i]['training_id']])->one();							
							#echo $recquery_rec->createCommand()->getRawSql();
							#echo "<pre>";print_r($recquery_rec);echo "</pre>";
							#echo '<tr>								
									#<td><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$trngquery_rec->id.'></td>
							#echo '<tbody style="overflow-x:auto; width:1200px; position:absolute>';
							if(isset($empname) && $empname != ''){
								echo '<tr>
										<td>'.$empname.'</td>';											
										foreach($trainingtopics as $restopics){			
											$topic_id=	$restopics->id;
											#$trg_attqry	= PorecTrainingAttendance::find->where(['training_batch_id'=>$data['training_batch_id'],'topic_id'=>$topic_id])->all();
											$trg_attqry = PorecTrainingAttendanceExisting::find()->where(['training_batch_id'=>$data['training_batch_id'],'topic_id'=>$topic_id])->one();
											#echo "<pre>";print_r($trg_attqry);echo "</pre>";
											$recid_str	=	$trg_attqry['ecode_id'];
											$lprec_id	=	$recruitment_arr[$i]['ecode_id'][$j];
											#echo "recid_str: ".$recid_str;
											$recid_arr	=	explode(',',$recid_str);
											if(in_array($lprec_id,$recid_arr)){
												$checkstatus	=	"CHECKED";
												$totaldays++;		
											}else{
												$checkstatus	=	"";
											}
											echo '<td align="center"><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$restopics->id.' '.$checkstatus.' onclick="return false"></td>';
											
										}
										
										//<td><input type="hidden" name="porec_id" id="porec_id" value='.$trngquery_rec->id.' /><input type="checkbox" name="selection[]" class="recruitmentcheckbox" value='.$recruitment_arr[$i]['rec_id'][$j].'></td>
										echo '<td align="center">'.$totaldays.'</td>';								
								echo   '</tr>';
							}
							#echo '</tbody>';
							
						}
					}
				}
					
		echo "</table>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}
	
	

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
	
	
	
	public function actionAttendanceadd(){
		$model 		= new PorecTraining();	
		
		$data = Yii::$app->request->post();		
		if ($data) {			
			$model->training_batch_id	=	$data['training_batch_id'];
			$model->rec_id				=	$data['selection'];
			$model->porec_id			=	$data['porec_id'];
			$model->faculty_name		=	$data['TrainingFaculty']['faculty_name'];			
			#$model->topic_name			=	$data['TrainingTopics']['topic_name'];			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$selected_recid	=	implode(',',$data['selection']);
			#foreach($data['selection'] as $recruitment){	
				$attmodel	= new PorecTrainingAttendance();	
				$attmodel->training_batch_id	=	$data['training_batch_id'];
				$attmodel->porec_id				=	$data['porec_id'];
				$attmodel->recruitment_id		=	$selected_recid;
				$attmodel->faculty_id			=	$data['TrainingFaculty']['faculty_name'];
				$attmodel->topic_id				=	$data['TrainingTopics']['topic_name'];
				$attmodel->attendance_date		=	date('Y-m-d',strtotime($data['PorecTraining']['attendance_date']));
				$attmodel->save();
				#echo "recruitment_id: ".$recruitment;
			#}
			#exit;
			return $this->render('training_attendance', [
				'model' => $model
			]);
		}
	}
	
	public function actionExistingattendanceadd(){
		$model 		= new PorecTraining();	
		#echo "hi";
		#exit;
		
		$data = Yii::$app->request->post();		
		if ($data) {			
			$model->training_batch_id	=	$data['training_batch_id'];
			$model->ecode			=	$data['selection'];
			$model->porec_id			=	$data['porec_id'];
			$model->faculty_name		=	$data['TrainingFaculty']['faculty_name'];			
			#$model->topic_name			=	$data['TrainingTopics']['topic_name'];			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$selected_ecodeid	=	implode(',',$data['selection']);
			#foreach($data['selection'] as $recruitment){	
				$attmodel	= new PorecTrainingAttendanceExisting();	
				$attmodel->training_batch_id	=	$data['training_batch_id'];
				$attmodel->porec_id				=	$data['porec_id'];
				$attmodel->ecode_id				=	$selected_ecodeid;
				$attmodel->faculty_id			=	$data['TrainingFaculty']['faculty_name'];
				$attmodel->topic_id				=	$data['TrainingTopics']['topic_name'];
				$attmodel->attendance_date		=	date('Y-m-d',strtotime($data['PorecTraining']['attendance_date']));
				$attmodel->save();
				#echo "recruitment_id: ".$recruitment;
			#}
			#exit;
			return $this->render('training_attendance_existing', [
				'model' => $model
			]);
		}
	}
		
	public function actionPrint1()
    {  
		$model 		= new PorecTraining();	
		
		$data = Yii::$app->request->post();		
		if ($data) {			
			$model->training_batch_id	=	$data['training_batch_id'];
			$model->training_topic_id	=	$data['training_topic_id'];
			$model->rec_id				=	$data['selection'];
			$model->porec_id			=	$data['porec_id'];
			$model->faculty_name		=	$data['TrainingFaculty']['faculty_name'];
			$model->print_type			=	$data['TrainingFaculty']['print_type'];	
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			
			/*foreach($data['selection'] as $recruitment){	
				$attmodel	= new PorecTrainingAttendance();	
				$attmodel->training_batch_id	=	$data['training_batch_id'];
				$attmodel->porec_id				=	$data['porec_id'];
				$attmodel->recruitment_id		=	$recruitment;
				$attmodel->faculty_id			=	$data['TrainingFaculty']['faculty_name'];
				$attmodel->attendance_date		=	date('Y-m-d',strtotime($data['PorecTraining']['attendance_date']));
				$attmodel->save();
				#echo "recruitment_id: ".$recruitment;
			}*/
			#exit;
			return $this->render('print1', [
				'model' => $model
			]);
		}
    }
	
	public function actionPrint2()
    {
        $model 		= new PorecTraining();	
		
		$data = Yii::$app->request->post();		
		if ($data) {			
			$model->training_batch_id	=	$data['training_batch_id'];
			$model->training_topic_id	=	$data['training_topic_id'];
			$model->rec_id				=	$data['selection'];
			$model->porec_id			=	$data['porec_id'];
			$model->faculty_name		=	$data['TrainingFaculty']['faculty_name'];
			$model->print_type			=	$data['TrainingFaculty']['print_type'];	
			
			return $this->render('print2', [
				'model' => $model
			]);
		}
    }
	
	public function actionPrint3()
    {
        #$searchModel = new PorecTrainingSearch();				
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$model = new PorecTraining();
		
		/*return $this->render('print1', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);*/
		
		/*if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['print3', 'id' => $model->id]);
        }		
		
        return $this->render('print3', [
            'model' => $model,
        ]);*/
		
		$data = Yii::$app->request->post();		
		if ($data) {			
			$model->training_batch_id	=	$data['training_batch_id'];
			$model->training_topic_id	=	$data['training_topic_id'];
			$model->rec_id				=	$data['selection'];
			$model->porec_id			=	$data['porec_id'];
			$model->faculty_name		=	$data['TrainingFaculty']['faculty_name'];
			$model->print_type			=	$data['TrainingFaculty']['print_type'];	
			
			return $this->render('print3', [
				'model' => $model
			]);
		}
    }	
}