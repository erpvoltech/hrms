<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "esi_list".
 *
 * @property int $id
 * @property int $esi_list_id
 * @property int $esi_list_no
 * @property int $empid
 * @property double $gross
 * @property double $esi_wages
 * @property double $esi_employee_contribution
 * @property double $esi_employer_contribution
 */
class EsiList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esi_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['esi_list_id', 'esi_list_no', 'empid', 'esino', 'gross', 'esi_wages', 'esi_employee_contribution', 'esi_employer_contribution'], 'required'],
            [['esi_list_id', 'esi_list_no', 'empid'], 'integer'],
            [['gross', 'esi_wages', 'esi_employee_contribution', 'esi_employer_contribution'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'esi_list_id' => 'List ID',
            'esi_list_no' => 'List No',
            'empid' => 'Emp Code',
            'gross' => 'Gross',
            'esi_wages' => 'ESI Wages',
            'esi_employee_contribution' => 'ESI Employee Contribution',
            'esi_employer_contribution' => 'ESI Employer Contribution',
        ];
    }

    public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
    }
}
