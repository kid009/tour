<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "community_image".
 *
 * @property int $community_image_id
 * @property string $community_id
 * @property string $community_image_name
 * @property string $community_image_type
 * @property string $community_image_subtype
 * @property string $ref_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $community_image_file
 *
 * @property Community $community
 */
class CommunityImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id'], 'required'],
            [['community_id', 'ref_id'], 'default', 'value' => null],
            [['community_id', 'ref_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['community_image_name', 'community_image_type', 'community_image_subtype', 'create_by', 'update_by', ], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['community_image_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_image_id' => 'Community Image ID',
            'community_id' => 'Community ID',
            'community_image_name' => 'Community Image Name',
            'community_image_type' => 'Community Image Type',
            'community_image_subtype' => 'Community Image Subtype',
            'ref_id' => 'Ref ID',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'community_image_file' => 'Community Image File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }
}
