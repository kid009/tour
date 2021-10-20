<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_group".
 *
 * @property int $activity_group_id
 * @property string $activity_group_name
 * @property string $activity_group_detail
 * @property string $activity_group_name_en
 * @property string $activity_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class ActivityGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_group_detail', 'activity_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['activity_group_name', 'activity_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['activity_group_name', 'activity_group_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_group_id' => 'Activity Group ID',
            'activity_group_name' => 'ชื่อกลุ่มกิจกรรม',
            'activity_group_detail' => 'Activity Group Detail',
            'activity_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'activity_group_detail_en' => 'Activity Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}