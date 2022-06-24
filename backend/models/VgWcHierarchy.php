<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_wc_hierarchy".
 *
 * @property int $id
 * @property int $wc_id
 * @property string $categories
 * @property int $no_of_persons
 * @property double $gross_salary_total
 */
class VgWcHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_wc_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wc_id', 'categories', 'no_of_persons', 'gross_salary_total'], 'required'],
            [['wc_id', 'no_of_persons'], 'integer'],
            [['gross_salary_total'], 'number'],
            [['categories'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wc_id' => 'WC ID',
            'categories' => 'Categories',
            'no_of_persons' => 'No of Persons',
            'gross_salary_total' => 'Gross Salary Total',
        ];
    }
}
