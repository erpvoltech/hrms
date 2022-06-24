<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pf_list".
 *
 * @property int $id
 * @property int $list_id
 * @property int $list_no
 * @property int $empid
 * @property double $gross
 * @property double $epf_wages
 * @property double $eps_wages
 * @property double $edli_wages
 * @property double $epf_contri_remitted
 * @property double $eps_contri_remitted
 * @property double $epf_eps_diff_remitted
 * @property double $ncp_days
 * @property double $refund_of_advance
 */
class PfList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pf_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['list_id', 'list_no', 'empid', 'uanno', 'gross', 'epf_wages', 'eps_wages', 'edli_wages', 'epf_contri_remitted', 'eps_contri_remitted', 'epf_eps_diff_remitted', 'ncp_days', 'refund_of_advance'], 'required'],
            [['list_id', 'list_no', 'empid'], 'integer'],
            [['gross', 'epf_wages', 'eps_wages', 'edli_wages', 'epf_contri_remitted', 'eps_contri_remitted', 'epf_eps_diff_remitted', 'ncp_days', 'refund_of_advance'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'list_no' => 'List No',
            'empid' => 'Emp. Code',
            'gross' => 'Gross',
            'epf_wages' => 'EPF Wages',
            'eps_wages' => 'EPS Wages',
            'edli_wages' => 'EDLI Wages',
            'epf_contri_remitted' => 'EPF Contri Remitted',
            'eps_contri_remitted' => 'EPS Contri Remitted',
            'epf_eps_diff_remitted' => 'EPF EPS Diff Remitted',
            'ncp_days' => 'NCP Days',
            'refund_of_advance' => 'Refund Of Advance',
        ];
    }
	
	public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
    }
}
