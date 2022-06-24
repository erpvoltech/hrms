<?php 
use app\models\TrainingBatch;

        $created_at= $_GET['date'];
		$model->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
		$model->training_batch_name =$_GET['name'];
		$model->save();  

		$rows =  TrainingBatch::find()->all();

		foreach ($rows as $row) {
				echo "<option selected value='$row->id'>$row->training_batch_name</option>";
		}
?>
