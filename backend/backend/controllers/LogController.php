<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use yii\data\SqlDataProvider;

class LogController extends Controller
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
        $dataProvider = new SqlDataProvider([
            'sql' => "select log_user, log_url, log_server_name, log_date::TIMESTAMP::DATE as date , log_date::TIMESTAMP::time as time
            from bb_user_log
            order by log_date desc "
        ]);

        return $this->render('index', [
            //'data' => $data,
            'dataProvider' => $dataProvider,
        ]);
    }

    
}
