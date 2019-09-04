<?php

namespace backend\models;

use yii\base\Model;


/**
 * ModelStatis form
 */
class ModelStatis extends Model
{
    public $code_karton;
    public $code_kemas;
    public $sell;
    public $no_batch;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return[
            [['code_karton','code_kemas','sell', 'no_batch'],'safe'],
            [['code_karton'], 'string', 'min' => 54, 'max' => 54],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'code_karton' => 'Code Karton',
            'code_kemas' => 'Code Kemas',
            'sell' => 'Sell',
            'no_batch' => 'No Batch',
        ];
    }
}
