<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "geography".
 *
 * @property int $geo_id
 * @property string $geo_name
 */
class Geography extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_geography';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['geo_name'], 'required'],
            [['geo_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'geo_id' => 'Geo ID',
            'geo_name' => 'Geo Name',
        ];
    }
}
