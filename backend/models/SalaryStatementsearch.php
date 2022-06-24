<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpSalary;

/**
 * SalarySatementsearch represents the model behind the search form of `common\models\EmpSalary`.
 */
class SalaryStatementsearch extends EmpSalary
{
   public $division;
   public $salarymonth;
   public $unit_group;
    public function rules()
    {
        return [
			[['salarymonth'],'required'],
            [['id', 'user', 'empid', 'designation', 'unit_id', 'department_id', 'division'], 'integer'],
            [['unit_group','salarymonth','date', 'attendancetype', 'work_level', 'grade', 'salary_structure', 'month'], 'safe'],
            [['earnedgross', 'paiddays', 'forced_lop', 'paidallowance', 'statutoryrate', 'basic', 'hra', 'spl_allowance', 'dearness_allowance', 'conveyance_allowance', 'over_time', 'arrear', 'advance_arrear_tes', 'lta_earning', 'medical_earning', 'guaranted_benefit', 'holiday_pay', 'washing_allowance', 'dust_allowance', 'performance_pay', 'other_allowance', 'total_earning', 'pf', 'insurance', 'professional_tax', 'esi', 'advance', 'tes', 'mobile', 'loan', 'rent', 'tds', 'lwf', 'other_deduction', 'total_deduction', 'net_amount', 'pf_employer_contribution', 'esi_employer_contribution', 'pli_employer_contribution', 'lta_employer_contribution', 'med_employer_contribution', 'earned_ctc'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EmpSalary::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user' => $this->user,
            'date' => $this->date,
            'empid' => $this->empid,
            'designation' => $this->designation,
            'unit_id' => $this->unit_id,
            'department_id' => $this->department_id,
            'earnedgross' => $this->earnedgross,
            'month' => $this->month,
            'paiddays' => $this->paiddays,
            'forced_lop' => $this->forced_lop,
            'paidallowance' => $this->paidallowance,
            'statutoryrate' => $this->statutoryrate,
            'basic' => $this->basic,
            'hra' => $this->hra,
            'spl_allowance' => $this->spl_allowance,
            'dearness_allowance' => $this->dearness_allowance,
            'conveyance_allowance' => $this->conveyance_allowance,
            'over_time' => $this->over_time,
            'arrear' => $this->arrear,
            'advance_arrear_tes' => $this->advance_arrear_tes,
            'lta_earning' => $this->lta_earning,
            'medical_earning' => $this->medical_earning,
            'guaranted_benefit' => $this->guaranted_benefit,
            'holiday_pay' => $this->holiday_pay,
            'washing_allowance' => $this->washing_allowance,
            'dust_allowance' => $this->dust_allowance,
            'performance_pay' => $this->performance_pay,
            'other_allowance' => $this->other_allowance,
            'total_earning' => $this->total_earning,
            'pf' => $this->pf,
            'insurance' => $this->insurance,
            'professional_tax' => $this->professional_tax,
            'esi' => $this->esi,
            'advance' => $this->advance,
            'tes' => $this->tes,
            'mobile' => $this->mobile,
            'loan' => $this->loan,
            'rent' => $this->rent,
            'tds' => $this->tds,
            'lwf' => $this->lwf,
            'other_deduction' => $this->other_deduction,
            'total_deduction' => $this->total_deduction,
            'net_amount' => $this->net_amount,
            'pf_employer_contribution' => $this->pf_employer_contribution,
            'esi_employer_contribution' => $this->esi_employer_contribution,
            'pli_employer_contribution' => $this->pli_employer_contribution,
            'lta_employer_contribution' => $this->lta_employer_contribution,
            'med_employer_contribution' => $this->med_employer_contribution,
            'earned_ctc' => $this->earned_ctc,
            'revised' => $this->revised,
        ]);

        $query->andFilterWhere(['like', 'attendancetype', $this->attendancetype])
            ->andFilterWhere(['like', 'work_level', $this->work_level])
            ->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'salary_structure', $this->salary_structure]);

        return $dataProvider;
    }
}