<?php

namespace app\models;

use Yii;

class ResearchPathofOutputApply extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_path_of_output_apply';
    }

    public function rules()
    {
        return [
            [['researcher_tourism_product_id', 'researcher_innovation_id', 'researcher_output_apply_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],

            // [['researcher_output_apply_id'], 'exist', 'skipOnError' => true, 'targetClass' => getResearchOutputApply::className(), 'targetAttribute' => ['researcher_output_apply_id' => 'researcher_output_apply_id']],

            // [['researcher_tourism_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchTourismProduct::className(), 'targetAttribute' => ['researcher_tourism_product_id' => 'researcher_tourism_product_id']],

            // [['researcher_innovation_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchInnovation::className(), 'targetAttribute' => ['researcher_innovation_id' => 'researcher_innovation_id']],

        ];
    }

    // public function getResearchOutputApply()
    // {
    //     return $this->hasOne(getResearchOutputApply::className(), ['researcher_output_apply_id' => 'researcher_output_apply_id']);
    // }

    // public function getResearchTourismProduct()
    // {
    //     return $this->hasOne(ResearchTourismProduct::className(), ['researcher_tourism_product_id' => 'researcher_tourism_product_id']);
    // }

    // public function getResearchInnovation()
    // {
    //     return $this->hasOne(ResearchInnovation::className(), ['researcher_innovation_id' => 'researcher_innovation_id']);
    // }
    
}