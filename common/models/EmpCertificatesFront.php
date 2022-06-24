<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_certificates".
 *
 * @property int $id
 * @property int $empid
 * @property string $certificatesname
 * @property string $certificateno
 * @property string $issue_authority
 */
class EmpCertificatesFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_certificates_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['certificatesname', 'issue_authority'], 'string', 'max' => 250],
            [['certificateno'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Empid',
            'certificatesname' => 'Certificatesname',
            'certificateno' => 'Certificateno',
            'issue_authority' => 'Issue Authority',
        ];
    }
}
