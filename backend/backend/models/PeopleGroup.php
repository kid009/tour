<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "people_group".
 *
 * @property int $people_group_id
 * @property string $people_group_name
 * @property string $people_group_detail
 * @property string $people_group_name_en
 * @property string $people_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property People[] $peoples
 */
class PeopleGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['people_group_detail', 'people_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['people_group_name', 'people_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['people_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['people_group_name','people_group_name_en',], 
                'unique',
                'message' => '**ชื่อนี้ซ้ำในระบบ'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'people_group_id' => 'People Group ID',
            'people_group_name' => 'ชื่อกลุ่ม',
            'people_group_detail' => 'People Group Detail',
            'people_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'people_group_detail_en' => 'People Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeoples()
    {
        return $this->hasMany(People::className(), ['people_group_id' => 'people_group_id']);
    }
}
