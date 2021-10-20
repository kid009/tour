<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_group".
 *
 * @property int $user_group_id
 * @property string $user_group_name
 * @property string $user_group_detail
 * @property string $user_group_status
 * @property string $community_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Userweb[] $userwebs
 */
class UserGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_group_detail'], 'string'],
            [['community_id'], 'default', 'value' => null],
            [['community_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['user_group_name', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['user_group_status', 'enable_filter_content'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_group_id' => 'User Group ID',
            'user_group_name' => 'ชื่อกลุ่ม',
            'user_group_detail' => 'รายละเอียด',
            'user_group_status' => 'สถานะ',
            'community_id' => 'ชุมชน',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserwebs()
    {
        return $this->hasMany(Userweb::className(), ['user_group_id' => 'user_group_id']);
    }
    
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }
    
}
