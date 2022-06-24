<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ProjectDetails;
use yii\jui\DatePicker;

$project = ProjectDetails::findOne(['id'=>$model->project_id]);




?>
<div class="project-details-project-tracking">

     <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?> 
		
		<div class="row" style="margin-top:10px;font-weight:800px">
			<div class="col-md-2" align="right">
			Project Code :
			</div>
			<div class="col-md-2">
			<?=$model->project->project_code?>
			</div>			
			<div class="col-md-2" align="right">
			Location Code :
			</div>
			<div class="col-md-2">
			<?=$model->project->location_code?>
			</div>
			<div class="col-md-2" align="right">
			Customer :
			</div>
			<div class="col-md-2">
			<?=$project->customer->customer_name?>
			</div>		
		</div>
		
		<?= $form->field($model, 'project_id')->hiddenInput(['value'=> $project->id])->label(false); ?>
		<div class="row" style="margin-top:50px">
			<div class="col-lg-6" >			
				<?=
               $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div>
			<div class="col-lg-6">			
			<?=
               $form->field($model, 'attendance_division')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div></div> <div class="row">
			<div class="col-lg-6">
			  <?=
               $form->field($model, 'attendance_send')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			
			</div>
		
		
		
			<div class="col-lg-6">
			<?=
               $form->field($model, 'prs_received')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div> </div>
			<div class="row">
			<div class="col-lg-6">
				<?=
               $form->field($model, 'prs_send_division')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div>
		
			
		
			<div class="col-lg-6">			
			<?=
               $form->field($model, 'docs_division')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div> </div><div class="row">
			<div class="col-lg-6">			
			<?=
               $form->field($model, 'docs_send')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
			</div>
		
			
		
			<div class="col-lg-6">
			<?= $form->field($model, 'invoice_no') ?>
			</div> </div>
			<div class="row">
			<div class="col-lg-6">
			<?= $form->field($model, 'clearance_status') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
			<?= $form->field($model, 'remark')->textarea(['rows' => '6']) ?>
		</div>
		</div>
		<br>
		<div class="row">	
		<div class="col-lg-4"></div>
		<div class="col-lg-6">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div></div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-project-tracking -->
