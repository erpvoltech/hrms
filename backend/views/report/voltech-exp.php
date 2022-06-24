<?php
error_reporting(0);
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\Unit;
use yii\helpers\ArrayHelper;
use yii\db\Query;
?>

<div class="vg-gpa-policy-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">Voltech Experience Report</font>
            <span class="pull-right"><button class="btn btn-xs btn-danger" type="button" id="exportprobation">Export</button></span>
        </div>
        <div class="panel-body" style="padding: 3px">
            <div class="row">
                <div class="col-md-12">
                    <table style="font-size:12px;" >
                        <tr>
                            <th>Sl.No</th>
                            <th>Emp Code</th>
                            <th>Emp Name</th>                                                     
                            <th>DoJ</th>
                            <th>Y M D</th> 
							<th>Exp</th> 
                            <th>Status</th>							
							<th>Division</th>
							<th>Unit</th>
						</tr>
                    <?php

                    /*$connection = \Yii::$app->db;
                    $command = $connection->createCommand("SELECT empcode,empname,doj,confirmation_date,status,unit_id,DATEDIFF(CURDATE(), doj) AS days,probation FROM emp_details WHERE (confirmation_date IS NULL OR confirmation_date='') AND (probation IS NOT NULL AND probation <> '') AND status='Active' ORDER BY doj ASC");
                    $result = $command->queryAll();*/

                    $model = EmpDetails::find()->
							Where(['=','status','Active'])
                            ->orderBy(['doj'=>SORT_ASC,])
                            ->all();

                    $i = 1;
                    foreach ($model as $duration) {
                        $unit = Unit::find()->where(['id' => $duration->unit_id])->one();
                        $division = Division::find()->where(['id' => $duration->division_id])->one();
                        $currentDt = date('Y-m-d');
                        $cd = date_create($currentDt);

                        $doj = date_create(date('Y-m-d', strtotime($duration['doj'])));
                        $diff = date_diff($doj,$cd);
                        $totalYears = $diff->format("%y");
						$totalMonths = $diff->format("%m");
						$totalDays = $diff->format("%d");

                        //echo $i.' -- '.$duration['empname'].' -- '.$duration['doj'].' -- '.$duration['probation'].' -- '.$unit['name'].' -- '.$totaldays.' -- '.$duration['confirmation_date'].'<br>';

                        //$probationMonths = strtolower(str_replace(' ', '', $duration['probation']));
                        //echo $duration['unit_id']."<br>";
                        //echo $unit;                          
                        echo '<tr><td>'.$i.'</td><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $totalYears .' Years '. $totalMonths .' Months '.$totalDays.' Days </td><td>' . $totalYears .'.'. $totalMonths .' </td><td>'.$duration['status'].'</td><td>'.$unit['name'].'</td><td>'.$division['division_name'].'</td></tr>';                                                      
						$i++;
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<<JS

     $("#exportprobation").click(function() {

     var exporttype = 1;

            var printWindow = window.open('export-voltech-exp', 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
            printWindow.document.title = "Downloading";
            printWindow.addEventListener('load', function () {
            }, true);
    });

JS;
$this->registerJs($script);
?>