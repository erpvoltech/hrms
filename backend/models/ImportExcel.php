<?php

namespace app\models;

use yii\base\Model;

class ImportExcel extends Model
{
	public $file;
	public $uploadtype;
	public $uploaddata;
	
	public function rules()
	{
		return [
		    [['uploadtype','uploaddata'], 'required'],
			['file', 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
		];
	}
	
	  public function attributeLabels()
    {
        return [
            'file' => 'Import File (.xlsx)',
            'uploadtype' => 'Upload Status',
			'uploaddata' => 'Upload Data',
			];
    }
}
