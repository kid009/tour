<?php

namespace common\rbac;

use yii\rbac\Rule;

class AuthorRule extends Rule 
{
    public $name = 'isAuthor';
    
    public function execute($user_id, $item, $params)
    {
        /*if(isset($params['model'])) {
            return $params['model']->create_by == $user_id;
        }
        else {
            return false;
        }*/
        return isset($params['model']) ? $params['model']->create_by == $user_id : false;
    }
}
