<?php

namespace app\models;

use Yii;

class EntrepreneurGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entrepreneur_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entrepreneur_group_detail', 'entrepreneur_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['entrepreneur_group_name', 'entrepreneur_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['entrepreneur_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['entrepreneur_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['entrepreneur_group_name','entrepreneur_group_name_en',], 
                'unique',
                'message' => '**ชื่อนี้ซ้ำในระบบ**'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entrepreneur_group_id' => 'entrepreneur_group_id',
            'entrepreneur_group_name' => 'ชื่อกลุ่ม',
            'entrepreneur_group_detail' => 'รายละเอียด',
            'entrepreneur_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'entrepreneur_group_detail_en' => 'รายละเอียดภาษาอังกฤษ',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    
    public function getEntrepreneurs()
    {
        return $this->hasMany(Entrepreneur::className(), ['entrepreneur_group_id' => 'entrepreneur_group_id']);
    }

}
