<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use app\models\AppointmentLetter;

	 $id = Yii::$app->getRequest()->getQueryParam('id');
	

      $app_letter = AppointmentLetter::find()
              ->where(['empid' =>$id])
              ->one();
			  
			  if($app_letter)	{	?>			
			  <?php echo Html::img('@web/img/logo.jpg', ['class' => 'pull-left img-responsive']); ?><br>
			  <?php
				  echo $app_letter->letter;
				  }	 else {
				   echo 'Order not Generated';
				  }
?>