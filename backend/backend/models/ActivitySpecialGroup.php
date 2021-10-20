<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_special_group".
 *
 * @property string $activity_id
 * @property int $activity_special_group_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $special_group_id
 *
 * @property Activity $activity
 * @property SpecialGroup $specialGroup
 */
class ActivitySpecialGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_special_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'special_group_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['activity_id', 'special_group_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['special_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialGroup::className(), 'targetAttribute' => ['special_group_id' => 'special_group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'กิจกรรม',
            'activity_special_group_id' => 'ID',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'special_group_id' => 'กลุ่มอาชีพ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['activity_id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialGroup()
    {
        return $this->hasOne(SpecialGroup::className(), ['special_group_id' => 'special_group_id']);
    }
}
