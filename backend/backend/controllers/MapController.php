<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Community;
use yii\db\Query;
use app\models\Province;
use app\models\Amphur;
use app\models\Tambon;
use yii\helpers\ArrayHelper;
use yii\web\Session;

class MapController extends Controller 
{
    // public function init()
    // {
    //     $session = new Session();
    //     $session->open();

    //     if(empty($session['user_id'])){
    //         return $this->redirect('index.php?r=account/login');
    //     }

    //     parent::init();
    // }

    public function actionIndex() 
    {
        if(Yii::$app->request->post()){
            $province = Yii::$app->request->post('province');
            $community = Yii::$app->request->post('community');
        }
        else{
            $province = "";
            $community = "";
        }
        
        Yii::$app->session->set('province', $province);
        Yii::$app->session->set('community', $community);
        
        //ชุมชน
        $sqlCommunity = Yii::$app->db->createCommand("
            select  *
            from community
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%'
        ")->queryAll();
        $jsonCommunity = $this->getMapcondition($sqlCommunity, "community_name", "community_latitude", "community_longitude");
        
        //กำนัน
        $sqlTambonHeadman = Yii::$app->db->createCommand("
            select  *
            from people
            left join community on people.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and people_group_id = 9
        ")->queryAll();
        $jsonTambonHeadman = $this->getMapcondition($sqlTambonHeadman, "people_name", "people_latitude", "people_longitude");
        
        //ผู้ใหญ่บ้าน
        $sqlVillageHeadman = Yii::$app->db->createCommand("
            select  *
            from people
            left join community on people.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and people_group_id = 8
        ")->queryAll();
        $jsonVillageHeadman = $this->getMapcondition($sqlVillageHeadman, "people_name", "people_latitude", "people_longitude");
        
        //ปราชญ์ชาวบ้าน
        $sqlLocalWisdom = Yii::$app->db->createCommand("
            select  *
            from people
            left join community on people.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and people_group_id = 12
        ")->queryAll();
        $jsonLocalWisdom = $this->getMapcondition($sqlLocalWisdom, "people_name", "people_latitude", "people_longitude");
        
        //สถานที่ธรรมชาติ
        $sqlNature = Yii::$app->db->createCommand("
            select  *
            from nature
            left join community on nature.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' 
        ")->queryAll();
        $jsonNature = $this->getMapcondition($sqlNature, "nature_name", "nature_latitude", "nature_longitude");
        
        //กลุ่มอาชีพ
        $sqlCareer = Yii::$app->db->createCommand("
            select  *
            from special_group
            left join community on special_group.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' 
        ")->queryAll();
        $jsonCareer = $this->getMapcondition($sqlCareer, "special_group_name", "special_group_latitude", "special_group_longitude");

        //สถานที่ประวัติศาสตร์
        //ปราสาท
        $sqlPrasta = Yii::$app->db->createCommand("
            select  *
            from place
            left join community on place.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and place_group_id = 2 
        ")->queryAll();
        $jsonPrasat = $this->getMapcondition($sqlPrasta, "place_name", "place_latitude", "place_longitude");
        //พิพิธภัณฑ์
        $sqlMuseum = Yii::$app->db->createCommand("
            select  *
            from place
            left join community on place.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and place_group_id = 3 
        ")->queryAll();
        $jsonMuseum = $this->getMapcondition($sqlMuseum, "place_name", "place_latitude", "place_longitude");
        //ศาสนสถาน
        $sqlReligious = Yii::$app->db->createCommand("
            select  *
            from place
            left join community on place.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and place_group_id = 4 
        ")->queryAll();
        $jsonReligious = $this->getMapcondition($sqlReligious, "place_name", "place_latitude", "place_longitude");

        //สิ่งอำนวยความสะดวก
        //โรงพยาบาล
        $sqlHospital = Yii::$app->db->createCommand("
            select  *
            from poi
            left join community on poi.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and (poi_group_id = 4 or poi_group_id = 5)
        ")->queryAll();
        $jsonHospital = $this->getMapcondition($sqlHospital, "poi_name", "poi_latitude", "poi_longitude");
        
        //สถานีตำรวจ
        //$sqlPolice = $query->select(['*'])->from('poi')->where(['poi_group_id' => 3])->all();
        //$jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        $sqlPolice = Yii::$app->db->createCommand("
            select  *
            from poi
            left join community on poi.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and poi_group_id = 3
        ")->queryAll();
        $jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        
        //จุดบริการนักท่องเที่ยว
        //$sqlTour = $query->select(['*'])->from('poi')->where(['poi_group_id' => 2])->all();
        //$jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        $sqlTour = Yii::$app->db->createCommand("
            select  *
            from poi
            left join community on poi.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and poi_group_id = 2
        ")->queryAll();
        $jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        
        //โรงแรม
        //$jsonHotel = $this->getMap("hotel", "hotel_name", "hotel_latitude", "hotel_longitude");
        $sqlHotel = Yii::$app->db->createCommand("
            select  *
            from hotel
            left join community on hotel.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' 
        ")->queryAll();
        $jsonHotel = $this->getMapcondition($sqlHotel, "hotel_name", "hotel_latitude", "hotel_longitude");
        
        //ร้านอาหาร
        //$jsonRestaurant = $this->getMap("restaurant", "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        $sqlRestaurant = Yii::$app->db->createCommand("
            select  *
            from restaurant
            left join community on restaurant.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' 
        ")->queryAll();
        $jsonRestaurant = $this->getMapcondition($sqlRestaurant, "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        
        //โฮมสเตย์
        //$jsonHomestay = $this->getMap("homestay", "homestay_name", "homestay_latitude", "homestay_longitude");
        $sqlHomestay = Yii::$app->db->createCommand("
            select  *
            from homestay
            left join community on homestay.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' 
        ")->queryAll();
        $jsonHomestay = $this->getMapcondition($sqlHomestay, "homestay_name", "homestay_latitude", "homestay_longitude");
        
        //ปั๊มน้ำมัน
        //$sqlGas = $query->select(['*'])->from('poi')->where(['poi_group_id' => 1])->all();
        //$sqlGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");
        $sqlGas = Yii::$app->db->createCommand("
            select  *
            from poi
            left join community on poi.community_id = community.community_id
            left join tb_province on tb_province.province_id = community.province_id
            where province_name like '%$province%' and community_name like '%$community%' and poi_group_id = 1
        ")->queryAll();
        $jsonGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");

        return $this->render('index', [
                    'jsonCommunity' => $jsonCommunity,       
                    'jsonTambonHeadman' => $jsonTambonHeadman,
                    'jsonVillageHeadman' => $jsonVillageHeadman,
                    'jsonLocalWisdom' => $jsonLocalWisdom,
                    'jsonNature' => $jsonNature,
                    'jsonCareer' => $jsonCareer,
                    'jsonPrasat' => $jsonPrasat,
                    'jsonMuseum' => $jsonMuseum,
                    'jsonReligious' => $jsonReligious,
                    'jsonHospital' => $jsonHospital,
                    'jsonPolice' => $jsonPolice,
                    'jsonTour' => $jsonTour,
                    'jsonHotel' => $jsonHotel,
                    'jsonRestaurant' => $jsonRestaurant,
                    'jsonHomestay' => $jsonHomestay, 
                    'jsonGas' => $jsonGas,                              
        ]);
    }

    public function actionProvince() 
    {
        $model = new Community();
        $query = new Query();
        
        //session
        $province = Yii::$app->request->post('province');
        
        Yii::$app->session->set('province', $province);

        $amphur = Amphur::find()->where(['province_id' => $province])->all();
        $arrAmphur = ArrayHelper::map($amphur, 'amphur_id', 'amphur_name');
        //print_r($arrAmphur);
        //
        //ชุมชน
        $sqlCom = $query->select(['*'])->from('community')->where(['province_id' => $province])->all();
        $jsonCommu = $this->getMapcondition($sqlCom, "community_name", "community_latitude", "community_longitude");
        //กำนัน
        $sqlTambonHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 9, 'province_id' => $province])->all();
        $jsonTambonHeadman = $this->getMapcondition($sqlTambonHeadman, "people_name", "people_latitude", "people_longitude");
        //ผู้ใหญ่บ้าน
        $sqlVillageHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 8, 'province_id' => $province])->all();
        $jsonVillageHeadman = $this->getMapcondition($sqlVillageHeadman, "people_name", "people_latitude", "people_longitude");
        //ปราชญ์ชาวบ้าน
        $sqlLocalWisdom = $query->select(['*'])->from('people')->where(['people_group_id' => 12, 'province_id' => $province])->all();
        $jsonLocalWisdom = $this->getMapcondition($sqlLocalWisdom, "people_name", "people_latitude", "people_longitude");
        //สถานที่ธรรมชาติ
        $sqlNature = $query->select(['*'])
                ->from('nature')
                ->innerJoin('community', 'community.community_id = nature.community_id')
                ->where(['province_id' => $province])
                ->all();
        $jsonNature = $this->getMapcondition($sqlNature, "nature_name", "nature_latitude", "nature_longitude");
        //กลุ่มอาชีพ
        $sqlCareer = Yii::$app->db->createCommand("
            select * 
            from special_group
            inner join community on community.community_id = special_group.community_id
            where province_id = $province 
        ")->queryAll();
        $jsonCareer = $this->getMapcondition($sqlCareer, "special_group_name", "special_group_latitude", "special_group_longitude");
        //print_r($jsonCareer);
        
        //สถานที่ประวัติศาสตร์
        //ปราสาท
        $sqlPrasta = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where province_id = $province and place_group_id = 2
        ")->queryAll();
        $jsonPrasat = $this->getMapcondition($sqlPrasta, "place_name", "place_latitude", "place_longitude");
        //พิพิธภัณฑ์
        //$sqlMuseum = $query->select(['*'])->from('place')->where(['place_group_id' => 3, 'province_id' => $province])->all();
        $sqlMuseum = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where province_id = $province and place_group_id = 3
        ")->queryAll();
        $jsonMuseum = $this->getMapcondition($sqlMuseum, "place_name", "place_latitude", "place_longitude");
        //ศาสนสถาน
        $sqlReligious = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where province_id = $province and place_group_id = 4
        ")->queryAll();
        $jsonReligious = $this->getMapcondition($sqlReligious, "place_name", "place_latitude", "place_longitude");

        //สิ่งอำนวยความสะดวก
        //โรงพยาบาล
        $sqlHospital = Yii::$app->db->createCommand("
            select * 
            from poi
            where province_id = $province and poi_group_id = 5
        ")->queryAll();
        $jsonHospital = $this->getMapcondition($sqlHospital, "poi_name", "poi_latitude", "poi_longitude");
        //สถานีตำรวจ
        $sqlPolice = Yii::$app->db->createCommand("
            select * 
            from poi
            where province_id = $province and poi_group_id = 3
        ")->queryAll();        
        $jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        //จุดบริการนักท่องเที่ยว
        $sqlTour = Yii::$app->db->createCommand("
            select * 
            from poi
            where province_id = $province and poi_group_id = 2
        ")->queryAll();
        $jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        
        //โรงแรม
        $sqlHotel = Yii::$app->db->createCommand("
            select * 
            from hotel
            where province_id = $province 
        ")->queryAll();
        $jsonHotel = $this->getMapcondition($sqlHotel, "hotel_name", "hotel_latitude", "hotel_longitude");
        //ร้านอาหาร
        $sqlRestaurant = Yii::$app->db->createCommand("
            select * 
            from restaurant
            where province_id = $province 
        ")->queryAll();
        $jsonRestaurant = $this->getMapcondition($sqlRestaurant, "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        //โฮมสเตย์
        $sqlHomestay = Yii::$app->db->createCommand("
            select * 
            from homestay
            where province_id = $province 
        ")->queryAll();
        $jsonHomestay = $this->getMapcondition($sqlHomestay, "homestay_name", "homestay_latitude", "homestay_longitude");
        //ปั๊มน้ำมัน
        //$sqlGas = $query->select(['*'])->from('poi')->where(['poi_group_id' => 1, 'province_id' => $province])->all();
        $sqlGas = Yii::$app->db->createCommand("
            select * 
            from poi
            where province_id = $province and poi_group_id = 1
        ")->queryAll();
        $jsonGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");
        
        return $this->render('province', [
                    'model' => $model,
                    'arrAmphur' => $arrAmphur,
                    'jsonCommu' => $jsonCommu,
                    'jsonNature' => $jsonNature,
                    'jsonCareer' => $jsonCareer,
                    'jsonPrasat' => $jsonPrasat,
                    'jsonMuseum' => $jsonMuseum,
                    'jsonReligious' => $jsonReligious,
                    'jsonHospital' => $jsonHospital,
                    'jsonPolice' => $jsonPolice,
                    'jsonTour' => $jsonTour,
                    'jsonRestaurant' => $jsonRestaurant,
                    'jsonHotel' => $jsonHotel,
                    'jsonGas' => $jsonGas,
                    'jsonHomestay' => $jsonHomestay,
                    'jsonVillageHeadman' => $jsonVillageHeadman,
                    'jsonLocalWisdom' => $jsonLocalWisdom,
                    'jsonTambonHeadman' => $jsonTambonHeadman,

                    
        ]);
    }
    
    public function actionAmphur()
    {
        $model = new Community();
        $query = new Query();
        
        $province = Yii::$app->request->post('province');
        $amphur = Yii::$app->request->post('amphur');
        
        //session
        Yii::$app->session->set('province', $province);
        Yii::$app->session->set('amphur', $amphur);
        
        $amphur2 = Amphur::find()->where(['amphur_id' => $amphur])->all();
        $arrAmphur = ArrayHelper::map($amphur2, 'amphur_id', 'amphur_name');
        
        $district = Tambon::find()->where(['amphur_id' => $amphur])->all();
        $arrDistrict = ArrayHelper::map($district, 'tambon_id', 'tambon_name');
        
        //ชุมชน
        $sqlCom = $query->select(['*'])->from('community')->where(['amphur_id' => $amphur])->all();
        $jsonCom = $this->getMapcondition($sqlCom, "community_name", "community_latitude", "community_longitude");
        //กำนัน
        $sqlTambonHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 9, 'amphur_id' => $amphur])->all();
        $jsonTambonHeadman = $this->getMapcondition($sqlTambonHeadman, "people_name", "people_latitude", "people_longitude");
        //ผู้ใหญ่บ้าน
        $sqlVillageHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 8, 'amphur_id' => $amphur])->all();
        $jsonVillageHeadman = $this->getMapcondition($sqlVillageHeadman, "people_name", "people_latitude", "people_longitude");
        //ปราชญ์ชาวบ้าน
        $sqlLocalWisdom = $query->select(['*'])->from('people')->where(['people_group_id' => 12, 'amphur_id' => $amphur])->all();
        $jsonLocalWisdom = $this->getMapcondition($sqlLocalWisdom, "people_name", "people_latitude", "people_longitude");
        //สถานที่ธรรมชาติ
        $sqlNature = $query->select(['*'])
                ->from('nature')
                ->innerJoin('community', 'community.community_id = nature.community_id')
                ->where(['amphur_id' => $amphur])
                ->all();
        $jsonNature = $this->getMapcondition($sqlNature, "nature_name", "nature_latitude", "nature_longitude");
        //กลุ่มอาชีพ
        $sqlCareer = Yii::$app->db->createCommand("
            select * 
            from special_group
            inner join community on community.community_id = special_group.community_id
            where amphur_id = $amphur 
        ")->queryAll();
        $jsonCareer = $this->getMapcondition($sqlCareer, "special_group_name", "special_group_latitude", "special_group_longitude");
        //print_r($jsonCareer);
        
        //สถานที่ประวัติศาสตร์
        //ปราสาท
        $sqlPrasta = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where amphur_id = $amphur  and place_group_id = 2
        ")->queryAll();
        $jsonPrasat = $this->getMapcondition($sqlPrasta, "place_name", "place_latitude", "place_longitude");
        //พิพิธภัณฑ์
        //$sqlMuseum = $query->select(['*'])->from('place')->where(['place_group_id' => 3, 'province_id' => $province])->all();
        $sqlMuseum = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where amphur_id = $amphur  and place_group_id = 3
        ")->queryAll();
        $jsonMuseum = $this->getMapcondition($sqlMuseum, "place_name", "place_latitude", "place_longitude");
        //ศาสนสถาน
        $sqlReligious = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where amphur_id = $amphur and place_group_id = 4
        ")->queryAll();
        $jsonReligious = $this->getMapcondition($sqlReligious, "place_name", "place_latitude", "place_longitude");

        //สิ่งอำนวยความสะดวก
        //โรงพยาบาล
        $sqlHospital = Yii::$app->db->createCommand("
            select * 
            from poi
            where amphur_id = $amphur and poi_group_id = 5
        ")->queryAll();
        $jsonHospital = $this->getMapcondition($sqlHospital, "poi_name", "poi_latitude", "poi_longitude");
        //สถานีตำรวจ
        $sqlPolice = Yii::$app->db->createCommand("
            select * 
            from poi
            where amphur_id = $amphur and poi_group_id = 3
        ")->queryAll();        
        $jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        //จุดบริการนักท่องเที่ยว
        $sqlTour = Yii::$app->db->createCommand("
            select * 
            from poi
            where amphur_id = $amphur and poi_group_id = 2
        ")->queryAll();
        $jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        
        //โรงแรม
        $sqlHotel = Yii::$app->db->createCommand("
            select * 
            from hotel
            where amphur_id = $amphur 
        ")->queryAll();
        $jsonHotel = $this->getMapcondition($sqlHotel, "hotel_name", "hotel_latitude", "hotel_longitude");
        //ร้านอาหาร
        $sqlRestaurant = Yii::$app->db->createCommand("
            select * 
            from restaurant
            where amphur_id = $amphur
        ")->queryAll();
        $jsonRestaurant = $this->getMapcondition($sqlRestaurant, "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        //โฮมสเตย์
        $sqlHomestay = Yii::$app->db->createCommand("
            select * 
            from homestay
            where amphur_id = $amphur 
        ")->queryAll();
        $jsonHomestay = $this->getMapcondition($sqlHomestay, "homestay_name", "homestay_latitude", "homestay_longitude");
        //$jsonHomestay = $this->getMap("homestay", "homestay_name", "homestay_latitude", "homestay_longitude");
        //ปั๊มน้ำมัน
        //$sqlGas = $query->select(['*'])->from('poi')->where(['poi_group_id' => 1, 'province_id' => $province])->all();
        $sqlGas = Yii::$app->db->createCommand("
            select * 
            from poi
            where amphur_id = $amphur and poi_group_id = 1
        ")->queryAll();
        $jsonGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");
        
        return $this->render('amphur', [
            'model' => $model,
            'jsonCom' => $jsonCom,
            'jsonNature' => $jsonNature,
            'jsonCareer' => $jsonCareer,
            'jsonPrasat' => $jsonPrasat,
            'jsonMuseum' => $jsonMuseum,
            'jsonReligious' => $jsonReligious,
            'jsonHospital' => $jsonHospital,
            'jsonPolice' => $jsonPolice,
            'jsonTour' => $jsonTour,
            'jsonRestaurant' => $jsonRestaurant,
            'jsonHotel' => $jsonHotel,
            'jsonGas' => $jsonGas,
            'jsonHomestay' => $jsonHomestay,
            'jsonVillageHeadman' => $jsonVillageHeadman,
            'jsonLocalWisdom' => $jsonLocalWisdom,
            'jsonTambonHeadman' => $jsonTambonHeadman,
            'arrAmphur' => $arrAmphur,
            'arrDistrict' => $arrDistrict,
        ]);
    }
    
    public function actionDistrict()
    {
        $model = new Community();
        $query = new Query();
        
        $province = Yii::$app->request->post('province');
        $amphur = Yii::$app->request->post('amphur');
        $district = Yii::$app->request->post('district');
        //echo $district;
        //session
        Yii::$app->session->set('province', $province);
        Yii::$app->session->set('amphur', $amphur);
        Yii::$app->session->set('district', $district);
        
        $amphur2 = Amphur::find()->where(['amphur_id' => $amphur])->all();
        $arrAmphur = ArrayHelper::map($amphur2, 'amphur_id', 'amphur_name');

        $district2 = Tambon::find()->where(['tambon_id' => $district])->all();
        $arrDistrict = ArrayHelper::map($district2, 'tambon_id', 'tambon_name');
        //print_r($arrDistrict);
        
        $commu = Community::find()->where(['tambon_id' => $district])->all();
        $arrCommu = ArrayHelper::map($commu, 'community_id', 'community_name');
        //print_r($arrCommu);
        
        //ชุมชน
        $sqlCom = $query->select(['*'])->from('community')->where(['tambon_id' => $district])->all();
        $jsonCom = $this->getMapcondition($sqlCom, "community_name", "community_latitude", "community_longitude");
        
        //กำนัน
        $sqlTambonHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 9, 'tambon_id' => $district])->all();
        $jsonTambonHeadman = $this->getMapcondition($sqlTambonHeadman, "people_name", "people_latitude", "people_longitude");
        //ผู้ใหญ่บ้าน
        $sqlVillageHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 8, 'tambon_id' => $district])->all();
        $jsonVillageHeadman = $this->getMapcondition($sqlVillageHeadman, "people_name", "people_latitude", "people_longitude");
        //ปราชญ์ชาวบ้าน
        $sqlLocalWisdom = $query->select(['*'])->from('people')->where(['people_group_id' => 12, 'tambon_id' => $district])->all();
        $jsonLocalWisdom = $this->getMapcondition($sqlLocalWisdom, "people_name", "people_latitude", "people_longitude");
        //สถานที่ธรรมชาติ
        $sqlNature = $query->select(['*'])
                ->from('nature')
                ->innerJoin('community', 'community.community_id = nature.community_id')
                ->where(['tambon_id' => $district])
                ->all();
        $jsonNature = $this->getMapcondition($sqlNature, "nature_name", "nature_latitude", "nature_longitude");
        //กลุ่มอาชีพ
        $sqlCareer = Yii::$app->db->createCommand("
            select * 
            from special_group
            inner join community on community.community_id = special_group.community_id
            where tambon_id = $district
        ")->queryAll();
        $jsonCareer = $this->getMapcondition($sqlCareer, "special_group_name", "special_group_latitude", "special_group_longitude");
        //print_r($jsonCareer);
        
        //สถานที่ประวัติศาสตร์
        //ปราสาท
        $sqlPrasta = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where tambon_id = $district  and place_group_id = 2
        ")->queryAll();
        $jsonPrasat = $this->getMapcondition($sqlPrasta, "place_name", "place_latitude", "place_longitude");
        //พิพิธภัณฑ์
        //$sqlMuseum = $query->select(['*'])->from('place')->where(['place_group_id' => 3, 'province_id' => $province])->all();
        $sqlMuseum = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where tambon_id = $district  and place_group_id = 3
        ")->queryAll();
        $jsonMuseum = $this->getMapcondition($sqlMuseum, "place_name", "place_latitude", "place_longitude");
        //ศาสนสถาน
        $sqlReligious = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where tambon_id = $district and place_group_id = 4
        ")->queryAll();
        $jsonReligious = $this->getMapcondition($sqlReligious, "place_name", "place_latitude", "place_longitude");

        //สิ่งอำนวยความสะดวก
        //โรงพยาบาล
        $sqlHospital = Yii::$app->db->createCommand("
            select * 
            from poi
            where tambon_id = $district and poi_group_id = 5
        ")->queryAll();
        $jsonHospital = $this->getMapcondition($sqlHospital, "poi_name", "poi_latitude", "poi_longitude");
        //สถานีตำรวจ
        $sqlPolice = Yii::$app->db->createCommand("
            select * 
            from poi
            where tambon_id = $district and poi_group_id = 3
        ")->queryAll();        
        $jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        //จุดบริการนักท่องเที่ยว
        $sqlTour = Yii::$app->db->createCommand("
            select * 
            from poi
            where tambon_id = $district and poi_group_id = 2
        ")->queryAll();
        $jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        
        //โรงแรม
        $sqlHotel = Yii::$app->db->createCommand("
            select * 
            from hotel
            where tambon_id = $district
        ")->queryAll();
        $jsonHotel = $this->getMapcondition($sqlHotel, "hotel_name", "hotel_latitude", "hotel_longitude");
        //ร้านอาหาร
        $sqlRestaurant = Yii::$app->db->createCommand("
            select * 
            from restaurant
            where tambon_id = $district
        ")->queryAll();
        $jsonRestaurant = $this->getMapcondition($sqlRestaurant, "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        //โฮมสเตย์
        $sqlHomestay = Yii::$app->db->createCommand("
            select * 
            from homestay
            where tambon_id = $district
        ")->queryAll();
        $jsonHomestay = $this->getMapcondition($sqlHomestay, "homestay_name", "homestay_latitude", "homestay_longitude");
        //ปั๊มน้ำมัน
        $sqlGas = Yii::$app->db->createCommand("
            select * 
            from poi
            where tambon_id = $district and poi_group_id = 1
        ")->queryAll();
        $jsonGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");
        
        return $this->render('district', [
            'model' => $model,
            'arrAmphur' => $arrAmphur,
            'arrDistrict' => $arrDistrict,
            'arrCommu' => $arrCommu,
            'jsonCom' => $jsonCom,
            'jsonNature' => $jsonNature,
            'jsonCareer' => $jsonCareer,
            'jsonPrasat' => $jsonPrasat,
            'jsonMuseum' => $jsonMuseum,
            'jsonReligious' => $jsonReligious,
            'jsonHospital' => $jsonHospital,
            'jsonPolice' => $jsonPolice,
            'jsonTour' => $jsonTour,
            'jsonRestaurant' => $jsonRestaurant,
            'jsonHotel' => $jsonHotel,
            'jsonGas' => $jsonGas,
            'jsonHomestay' => $jsonHomestay,
            'jsonVillageHeadman' => $jsonVillageHeadman,
            'jsonLocalWisdom' => $jsonLocalWisdom,
            'jsonTambonHeadman' => $jsonTambonHeadman,
        ]);
    }
    
    public function actionCommu()
    {
        $model = new Community();
        $query = new Query();
        
        $province = Yii::$app->request->post('province');
        $amphur = Yii::$app->request->post('amphur');
        $district = Yii::$app->request->post('district');
        $community = Yii::$app->request->post('community');
        //session
        Yii::$app->session->set('province', $province);
        Yii::$app->session->set('amphur', $amphur);
        Yii::$app->session->set('district', $district);
        Yii::$app->session->set('community', $community);
        
        $amphur2 = Amphur::find()->all();
        $arrAmphur = ArrayHelper::map($amphur2, 'amphur_id', 'amphur_name');
        
        $district2 = Tambon::find()->all();
        $arrDistrict = ArrayHelper::map($district2, 'tambon_id', 'tambon_name');
        
        $commu = Yii::$app->request->post('community');        
        $commu2 = Community::find()->where(['community_id' => $commu])->all();
        $arrCommu = ArrayHelper::map($commu2, 'community_id', 'community_name');
        
        //ชุมชน
        $sqlCom = $query->select(['*'])->from('community')->where(['community_id' => $commu])->all();
        $jsonCom = $this->getMapcondition($sqlCom, "community_name", "community_latitude", "community_longitude");
        
        //กำนัน
        $sqlTambonHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 9, 'community_id' => $commu])->all();
        $jsonTambonHeadman = $this->getMapcondition($sqlTambonHeadman, "people_name", "people_latitude", "people_longitude");
        //ผู้ใหญ่บ้าน
        $sqlVillageHeadman = $query->select(['*'])->from('people')->where(['people_group_id' => 8, 'community_id' => $commu])->all();
        $jsonVillageHeadman = $this->getMapcondition($sqlVillageHeadman, "people_name", "people_latitude", "people_longitude");
        //ปราชญ์ชาวบ้าน
        $sqlLocalWisdom = $query->select(['*'])->from('people')->where(['people_group_id' => 12, 'community_id' => $commu])->all();
        $jsonLocalWisdom = $this->getMapcondition($sqlLocalWisdom, "people_name", "people_latitude", "people_longitude");
        //สถานที่ธรรมชาติ
        $sqlNature = $query->select(['*'])
                ->from('nature')
                ->innerJoin('community', 'community.community_id = nature.community_id')
                ->where(['nature.community_id' => $commu])
                ->all();
        $jsonNature = $this->getMapcondition($sqlNature, "nature_name", "nature_latitude", "nature_longitude");
        //กลุ่มอาชีพ
        $sqlCareer = Yii::$app->db->createCommand("
            select * 
            from special_group
            inner join community on community.community_id = special_group.community_id
            where special_group.community_id = $commu
        ")->queryAll();
        $jsonCareer = $this->getMapcondition($sqlCareer, "special_group_name", "special_group_latitude", "special_group_longitude");
        //print_r($jsonCareer);
        
        //สถานที่ประวัติศาสตร์
        //ปราสาท
        $sqlPrasta = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where place.community_id = $commu  and place_group_id = 2
        ")->queryAll();
        $jsonPrasat = $this->getMapcondition($sqlPrasta, "place_name", "place_latitude", "place_longitude");
        //พิพิธภัณฑ์
        //$sqlMuseum = $query->select(['*'])->from('place')->where(['place_group_id' => 3, 'province_id' => $province])->all();
        $sqlMuseum = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where place.community_id = $commu  and place_group_id = 3
        ")->queryAll();
        $jsonMuseum = $this->getMapcondition($sqlMuseum, "place_name", "place_latitude", "place_longitude");
        //ศาสนสถาน
        $sqlReligious = Yii::$app->db->createCommand("
            select * 
            from place
            inner join community on community.community_id = place.community_id
            where place.community_id = $commu and place_group_id = 4
        ")->queryAll();
        $jsonReligious = $this->getMapcondition($sqlReligious, "place_name", "place_latitude", "place_longitude");

        //สิ่งอำนวยความสะดวก
        //โรงพยาบาล
        $sqlHospital = Yii::$app->db->createCommand("
            select * 
            from poi
            where poi.community_id = $commu and poi_group_id = 5
        ")->queryAll();
        $jsonHospital = $this->getMapcondition($sqlHospital, "poi_name", "poi_latitude", "poi_longitude");
        //สถานีตำรวจ
        $sqlPolice = Yii::$app->db->createCommand("
            select * 
            from poi
            where poi.community_id = $commu and poi_group_id = 3
        ")->queryAll();        
        $jsonPolice = $this->getMapcondition($sqlPolice, "poi_name", "poi_latitude", "poi_longitude");
        //จุดบริการนักท่องเที่ยว
        $sqlTour = Yii::$app->db->createCommand("
            select * 
            from poi
            where community_id = $commu and poi_group_id = 2
        ")->queryAll();
        $jsonTour = $this->getMapcondition($sqlTour, "poi_name", "poi_latitude", "poi_longitude");
        
        //โรงแรม
        $sqlHotel = Yii::$app->db->createCommand("
            select * 
            from hotel
            where community_id = $commu
        ")->queryAll();
        $jsonHotel = $this->getMapcondition($sqlHotel, "hotel_name", "hotel_latitude", "hotel_longitude");
        //ร้านอาหาร
        $sqlRestaurant = Yii::$app->db->createCommand("
            select * 
            from restaurant
            where community_id = $commu
        ")->queryAll();
        $jsonRestaurant = $this->getMapcondition($sqlRestaurant, "restaurant_name", "restaurant_latitude", "restaurant_longitude");
        //โฮมสเตย์
        $sqlHomestay = Yii::$app->db->createCommand("
            select * 
            from homestay
            where community_id = $commu
        ")->queryAll();
        $jsonHomestay = $this->getMapcondition($sqlHomestay, "homestay_name", "homestay_latitude", "homestay_longitude");
        //ปั๊มน้ำมัน
        $sqlGas = Yii::$app->db->createCommand("
            select * 
            from poi
            where community_id = $commu and poi_group_id = 1
        ")->queryAll();
        $jsonGas = $this->getMapcondition($sqlGas, "poi_name", "poi_latitude", "poi_longitude");
        
        return $this->render('commu', [
            'model' => $model,
            'commu' => $commu,
            'jsonCom' => $jsonCom,
            'jsonNature' => $jsonNature,
            'jsonCareer' => $jsonCareer,
            'jsonPrasat' => $jsonPrasat,
            'jsonMuseum' => $jsonMuseum,
            'jsonReligious' => $jsonReligious,
            'jsonHospital' => $jsonHospital,
            'jsonPolice' => $jsonPolice,
            'jsonTour' => $jsonTour,
            'jsonRestaurant' => $jsonRestaurant,
            'jsonHotel' => $jsonHotel,
            'jsonGas' => $jsonGas,
            'jsonHomestay' => $jsonHomestay,
            'jsonVillageHeadman' => $jsonVillageHeadman,
            'jsonLocalWisdom' => $jsonLocalWisdom,
            'jsonTambonHeadman' => $jsonTambonHeadman,
            'arrCommu' => $arrCommu,
            'arrAmphur' => $arrAmphur,
            'arrDistrict' => $arrDistrict,
        ]);
    }

    public function getMap($table, $namePlace, $latitude, $longitude) 
    {
        //แสดงแผนที่บน Google Map
        $query = new Query();
        $data = $query->select(['*'])->from("$table")->all();
        $arrJson = []; //array
        foreach ($data as $key => $value) 
        {
            $name = $value["$namePlace"];
            $lat = $value["$latitude"];
            $lng = $value["$longitude"];

            $arr = []; //array
            $arr['name'] = $name;
            $arr['lat'] = $lat;
            $arr['lng'] = $lng;

            array_push($arrJson, $arr);
        }
        $json = json_encode($arrJson);

        return $json;
    }

    public function getMapcondition($sql, $namePlace, $latitude, $longitude) 
    {
        $arrJson = []; //array
        foreach ($sql as $key => $value) 
        {
            $name = $value["$namePlace"];
            $lat = $value["$latitude"];
            $lng = $value["$longitude"];

            $arr = []; //array
            $arr['name'] = $name;
            $arr['lat'] = $lat;
            $arr['lng'] = $lng;

            array_push($arrJson, $arr);
        }
        $json = json_encode($arrJson);

        return $json;
    }
}
