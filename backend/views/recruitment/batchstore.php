<?php 
use app\models\RecruitmentBatch;

        $created_at= $_GET['date'];
		$model->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
		$model->batch_name =$_GET['name'];
		$model->save();  

		$rows =  RecruitmentBatch::find()->all();

		foreach ($rows as $row) {
				echo "<option selected value='$row->id'>$row->batch_name</option>";
		}
?>
