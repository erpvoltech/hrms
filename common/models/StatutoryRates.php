<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statutory_rates".
 *
 * @property int $id
 * @property double $epf_ac_1_ee
 * @property double $epf_ac_1_er
 * @property double $epf_ac_10_er
 * @property double $epf_ac_2_er
 * @property double $epf_ac_21_er
 * @property double $esi_ee
 * @property double $esi_er
 */
class StatutoryRates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statutory_rates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['epf_ac_1_ee', 'epf_ac_1_er', 'epf_ac_10_er', 'epf_ac_2_er', 'epf_ac_21_er', 'esi_ee', 'esi_er'], 'required'],
            [['epf_ac_1_ee', 'epf_ac_1_er', 'epf_ac_10_er', 'epf_ac_2_er', 'epf_ac_21_er', 'esi_ee', 'esi_er'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'epf_ac_1_ee' => 'Epf Ac 1 Ee',
            'epf_ac_1_er' => 'Epf Ac 1 Er',
            'epf_ac_10_er' => 'Epf Ac 10 Er',
            'epf_ac_2_er' => 'Epf Ac 2 Er',
            'epf_ac_21_er' => 'Epf Ac 21 Er',
            'esi_ee' => 'Esi Ee',
            'esi_er' => 'Esi Er',
        ];
    }
}
