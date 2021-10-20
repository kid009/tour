<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use \rmrevin\yii\module\Comments\Permission;
use \rmrevin\yii\module\Comments\rbac\ItsMyComment;

class RbacController extends \yii\console\Controller 
{

    public function actionInit() 
    {
        Console::output('---------- Start ----------');
        $AuthManager = \Yii::$app->getAuthManager();
        /*$ItsMyCommentRule = new ItsMyComment();

        $AuthManager->add($ItsMyCommentRule);

        $AuthManager->add(new \yii\rbac\Permission([
            'name' => Permission::CREATE,
            'description' => 'Can create own comments',
        ]));
        $AuthManager->add(new \yii\rbac\Permission([
            'name' => Permission::UPDATE,
            'description' => 'Can update all comments',
        ]));
        $AuthManager->add(new \yii\rbac\Permission([
            'name' => Permission::UPDATE_OWN,
            'ruleName' => $ItsMyCommentRule->name,
            'description' => 'Can update own comments',
        ]));
        $AuthManager->add(new \yii\rbac\Permission([
            'name' => Permission::DELETE,
            'description' => 'Can delete all comments',
        ]));
        $AuthManager->add(new \yii\rbac\Permission([
            'name' => Permission::DELETE_OWN,
            'ruleName' => $ItsMyCommentRule->name,
            'description' => 'Can delete own comments',
        ]));*/
        
        $updatePost = $AuthManager->createPermission('updateBlog');
        $updatePost->description = 'Update application';
        $AuthManager->add($updatePost);
        
        // เรียกใช้งาน AuthorRule
        $rule = new \common\rbac\AuthorRule;
        $AuthManager->add($rule);
        
        // สร้าง permission ขึ้นมาใหม่เพื่อเอาไว้ตรวจสอบและนำ AuthorRule มาใช้งานกับ updateOwnPost
        $updateOwnPost = $AuthManager->createPermission('updateOwnPost');
        $updateOwnPost->description = 'อัปเดตโพสต์ของคุณเอง';
        $updateOwnPost->ruleName = $rule->name;
        $AuthManager->add($updateOwnPost);
                
        // เปลี่ยนลำดับ โดยใช้ updatePost อยู่ภายใต้ updateOwnPost และ updateOwnPost อยู่ภายใต้ author อีกที
        //$AuthManager->addChild($updateOwnPost, 'ProgramTour');
        
        Console::output('---------- Success! ----------');
    }//Init

}//class

?>