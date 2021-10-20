<?php

namespace backend\controllers;

use app\models\TourismExperience;
use app\models\TourismImpressive;
use app\models\TourismKnowhow;
use app\models\TourismStory;
use Yii;
use yii\web\Session;

class TourismDashboardController extends \yii\web\Controller
{
    public function init()
    {
        $session = new Session();
        $session->open();

        if(empty($session['user_id'])){
            return $this->redirect('index.php?r=account/login');
        }

        parent::init();
    }

    public function actionIndex()
    {
        $session = new Session();
        $session->open();

        $user_login = $session['user_login'];

        $countExprience = TourismExperience::find()->where(['create_by' => $user_login])->count();
        $expriences = TourismExperience::find()->where(['create_by' => $user_login])->all();

        $countKnowhow = TourismKnowhow::find()->where(['create_by' => $user_login])->count();
        $knowhows = TourismKnowhow::find()->where(['create_by' => $user_login])->all();

        $countImpressive = TourismImpressive::find()->where(['create_by' => $user_login])->count();
        $impressives = TourismImpressive::find()->where(['create_by' => $user_login])->all();

        $countStory = TourismStory::find()->where(['create_by' => $user_login])->count();
        $stories = TourismStory::find()->where(['create_by' => $user_login])->all();

        return $this->render('index', [
            'countExprience' => $countExprience,
            'expriences' => $expriences,
            'countKnowhow' => $countKnowhow,
            'knowhows' => $knowhows,
            'countImpressive' => $countImpressive,
            'impressives' => $impressives,
            'countStory' => $countStory,
            'stories' => $stories,
        ]);


      
    }

   
}
