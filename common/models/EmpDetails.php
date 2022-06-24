<?php

namespace common\models;

use Yii;

use common\components\AccessRule;


class EmpDetails extends \yii\db\ActiveRecord
{
    public $dojto;
    public $report_type;
    public static function tableName()
    {
        return 'emp_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [	
	    [['empcode', 'empname','doj'], 'required'],
            [['employment_type', 'appraisalmonth', 'category', 'joining_status', 'reasonforleaving', 'training_status'], 'string'],            
            [['doj', 'confirmation_date', 'recentdop', 'dateofleaving','resignation_date','last_working_date','dojto'], 'safe'],
            [['designation_id', 'division_id', 'unit_id', 'department_id','leave_eligible_status','service'], 'integer'],
            [['empcode'], 'string', 'max' => 20],
            [['empname', 'email', 'referedby', 'experience', 'status'], 'string', 'max' => 250],
            [['mobileno'], 'string', 'max' => 10],
            [['probation','report_type'], 'string', 'max' => 100],
         	[['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['empcode'], 'unique'],
        ];
    }

/**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employment_type' => 'Employment Type',
            'empcode' => 'Emp. Code',
            'empname' => 'Emp. Name',
            'doj' => 'DOJ',
            'confirmation_date' => 'Confirmation Date',
            'designation_id' => 'Designation',
            'category' => 'Category',
            'division_id' => 'Division',
            'unit_id' => 'Unit',
            'department_id' => 'Department',
            'email' => 'Email(Official)',
            'mobileno' => 'Mobile (CUG)',
            'referedby' => 'Refered By',
            'probation' => 'Probation',
            'appraisalmonth' => 'Appraisal Month',
            'recentdop' => 'Recent DOP',
            'joining_status' => 'Joining Status',
            'experience' => 'Experience',
            'dateofleaving' => 'Date of leaving',
            'reasonforleaving' => 'Reason for leaving',
			'last_working_date' => 'Last working date',
			'resignation_date' =>'Resignation date',
            'photo' => 'Photo',
            'status' => 'Status',
        ];
    }
    public function getDesignation()
    {
        return $this->hasOne(Designation::className(), ['id'=>'designation_id']);
    }

	public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
	
	public function getUnits()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
		}
    	public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'division_id']);
    }
	
	public function getEmployeePersonalDetail()
    {
        return $this->hasOne(EmpPersonaldetails::className(), ['empid' => 'id']);
    }
	public function getEmployeeAddress()
    {
        return $this->hasOne(EmpAddress::className(), ['empid' => 'id']);
    }
	
	 public function getEmployeeBankDetail()
    {
        return $this->hasOne(EmpBankdetails::className(), ['empid' => 'id']);
		}
	
	 public function getEmployeeCertificatesDetail()
    {
        return $this->hasOne(EmpCertificates::className(), ['empid' => 'id']);
    }
	
	 public function getEmployeeStatutoryDetail()
    {
        return $this->hasOne(EmpStatutorydetails::className(), ['empid' => 'id']);
    }
	
	 public function getEmployeeEducationDetail()
    {
        return $this->hasOne(EmpEducationdetails::className(), ['empid' => 'id']);
    }
	public function getEmployeePayScale()
    {
        return $this->hasOne(EmpStaffPayScale::className(), ['id' => 'staff_pay_scale_id']);
    }
	public function getEmployee()
    {
        return $this->hasOne(EmpSalaryUpload::className(), ['empid' => 'id']);
    }
	public function getAppointmentletter()
    {
        return $this->hasOne(AppointmentLetter::className(), ['empid' => 'id']);
    }
	public function getRemuneration()
    {
        return $this->hasOne(EmpRemunerationDetails::className(), ['empid' => 'id']);
    }
	public function getEmployment()
    {
        return $this->hasOne(PreviousEmployment::className(), ['empid' => 'id']);
    }
	public function getFamily()
    {
        return $this->hasOne(EmpFamilydetails::className(), ['empid' => 'id']);
    }
	public function getCertificate()
    {
        return $this->hasOne(EmpCertificates::className(), ['empid' => 'id']);
    }
		
	 public function upload($ID)
    {
        if ($this->validate()) {
            $this->photo->saveAs('emp_photo/' . $ID . '.' . $this->photo->extension);
            return true;
        } else {
            return false;
        }
    }
	
	function getIndianCurrency(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}
	function moneyFormatIndia($num){
		if($num > 0){
			$explrestunits = "" ;
			$num=preg_replace('/,+/', '', $num);
			$words = explode(".", $num);
			$des="00";
			if(count($words)<=2){
				$num=$words[0];
				if(count($words)>=2){$des=$words[1];}
				if(strlen($des)<2){$des=$des."0";}else{$des=substr($des,0,2);}
			}
			if(strlen($num)>3){
				$lastthree = substr($num, strlen($num)-3, strlen($num));
				$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
				$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
				$expunit = str_split($restunits, 2);
				for($i=0; $i<sizeof($expunit); $i++){
					// creates each of the 2's group and adds a comma to the end
					if($i==0)
					{
						$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
					}else{
						$explrestunits .= $expunit[$i].",";
					}
				}
				$thecash = $explrestunits.$lastthree;
			} else {
				$thecash = $num;
			}
			return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
		}
	}
	
}
