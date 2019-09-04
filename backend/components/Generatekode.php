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

class Generatekode extends \backend\models\Kodekarton
{
    public function getKode()
    {
        $_d = date("ymd");
        $_left =  $_d;
        $_first = '0001';
        $_len = strlen($_left);
        $no = $_left . $_first;
                
        $last_po = $this->find()
                ->select('id_parent')
                ->where('left(id_parent,'.$_len.')=:_left')
                ->params([':_left' => $_left])
                ->orderBy('id_parent DESC')
                ->one();
                
        if($last_po != null){
            $_no = substr($last_po->id_parent, $_len);
            $_no++;
            $_no = sprintf('%04s',$_no);
            $no = $_left . $_no;
        }
        return $no;
    }
}

