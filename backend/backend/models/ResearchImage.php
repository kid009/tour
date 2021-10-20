<?php

namespace app\models;

use Yii;

class ResearchImage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_image';
    }

    public function rules()
    {
        return [
            [['research_type_id', 'ref_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['research_image_file', 'research_image_name', 'create_by', 'update_by'], 'string', 'max' => 200],
            //[['research_type_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['research_image_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'research_image_id' => 'research_image_id',
            'research_type_id' => 'research_type_id',
            'ref_id' => 'ref_id',
            'research_image_file' => 'research_image_file',
            'research_image_name' => 'research_image_name',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

}
