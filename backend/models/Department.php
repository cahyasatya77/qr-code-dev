<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property string $kd_dept
 * @property string $nm_dept
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_dept', 'nm_dept'], 'required'],
            [['kd_dept'], 'string', 'max' => 10],
            [['nm_dept'], 'string', 'max' => 50],
            [['kd_dept'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_dept' => 'Kode Department',
            'nm_dept' => 'Nama Department',
        ];
    }
    
    /*
     * Generate Kode
     */
    
    public function generateKd_dept()
    {
        $_left = 'D';
        $_first = '0001';
        $_len = strlen($_left);
        $no = $_left . $_first;
        
        $last_po = $this->find()
                ->select('kd_dept')
                ->where('left(kd_dept,'.$_len.')=:_left')
                ->params([':_left'=>$_left])
                ->orderBy('kd_dept DESC')
                ->one();
        
        if($last_po!=null){
            $_no = substr($last_po->kd_dept, $_len);
            $_no++;
            $no = sprintf("D%04s",$_no);
        }
        return $no;
    }
}
