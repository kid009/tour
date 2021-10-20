<?php

namespace backend\controllers;

use yii\helpers\Json;

use app\models\Amphur;
use app\models\Tambon;

class GetaddressController extends \yii\web\Controller
{
    public function actionGetAmphur() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionGetTambon()
    {
        if(isset($_POST['depdrop_parents'])){
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            
            if($province_id != null){
                $data = $this->getTambon($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
    public function getAmphur($id)
    {
        $datas = Amphur::find()->where(['province_id'=>$id])->all();
        return $this->MapData($datas,'amphur_id','amphur_name');
    }
    
    public function getTambon($id)
    {
        $datas = Tambon::find()->where(['amphur_id' => $id])->all();
        return $this->MapData($datas, 'tambon_id', 'tambon_name');
    }
    
    public function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

}
