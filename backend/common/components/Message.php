<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\Html;

class MessageComponent extends Component
{
    public $content;
    
    public function display($content = null)
    {
        if($content != null){
            $this->content = 'Hello Yii 2.0';
        }
        echo Html::encode($this->content);
    }
}//class
