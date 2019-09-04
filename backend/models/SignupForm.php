<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;
use yii\db\Expression;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $kd_dept;
    public $name;
    public $level_access;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['kd_dept','required'],
            
            ['name', 'required'],
            ['name', 'string', 'max' => 50],
            
            ['level_access', 'required'],
            ['level_access', 'string', 'max' => 20],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->kd_dept = $this->kd_dept;
        $user->level_access = $this->level_access;
        $user->setPassword($this->password);
        $user->created_at = new Expression('NOW()');
        $user->updated_at = new Expression('NOW()');
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
