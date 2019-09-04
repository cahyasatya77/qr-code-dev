<?php
namespace backend\components;

use Yii;

/**
 * Extended yii\web\User
 *
 * This allows us to do "Yii::$app->user->something" by adding getters
 * like "public function getSomething()"
 *
 * So we can use variables and functions directly in `Yii::$app->user`
 */
class User extends \yii\web\User
{
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }

//    public function getName()
//    {
//        return \Yii::$app->user->identity->name;
//    }
    
    public function getCreateUser()
    {
        return date("M d Y", Yii::$app->user->identity->created_at);
    }
    
    public function getDepartment()
    {
        return \Yii::$app->user->identity->kd_dept;
    }
    
    public function getLevel()
    {
        return Yii::$app->user->identity->level_access;
    }
}