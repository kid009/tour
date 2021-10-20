<?php

namespace backend\controllers;

use Yii;
use yii\web\Session;

class DashboardController extends \yii\web\Controller
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
        return $this->render('index');
    }

}
