<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_company".
 *
 * @property int $id
 * @property string $company_name
 */
class VgInsuranceCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name'], 'required'],
            [['company_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
        ];
    }
}
