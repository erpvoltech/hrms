<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_tracking".
 *
 * @property int $id
 * @property int $project_id
 * @property string $attendance_division
 * @property string $attendance_send
 * @property string $prs_received
 * @property string $prs_send_division
 * @property string $docs_division
 * @property string $docs_send
 * @property string $invoice_no
 * @property string $clearance_status
 * @property string $remark
 */
class ProjectTracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id','month'], 'required'],
            [['project_id'], 'integer'],
            [['attendance_division', 'attendance_send', 'prs_received', 'prs_send_division', 'docs_division', 'docs_send','month'], 'safe'],
            [['remark'], 'string'],
            [['invoice_no', 'clearance_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project',
			'month' =>'Month',
            'attendance_division' => 'Attendance Received',
            'attendance_send' => 'Attendance Send',
            'prs_received' => 'PRS Received',
            'prs_send_division' => 'PRS Send Division',
            'docs_division' => 'Documents Received',
            'docs_send' => 'Documents Send',
            'invoice_no' => 'Invoice No',
            'clearance_status' => 'Clearance Status',
            'remark' => 'Remark',
        ];
    }
	
	public function getProject()
    {
        return $this->hasOne(ProjectDetails::className(), ['id'=>'project_id']);
    }
}
