<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kemas".
 *
 * @property int $id
 * @property int $id_karton
 * @property int $id_kemas
 *
 * @property Karton $karton
 */
class Kemas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $code_karton;
    public static function tableName()
    {
        return 'kemas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kemas'], 'required'],
            [['id_karton'], 'integer'],
            [['id_kemas','is_active','is_sample','is_sold'],'string','max' => 100],
            ['is_active', 'default', 'value' => 'TRUE'],
            ['is_sample','default', 'value' => 'FALSE'],
            ['is_sold','default', 'value' => 'FALSE'],
            [['id','code_karton', 'is_active','is_sample', 'is_sold'], 'safe'],
            [['id_kemas'], 'unique'],
//            [['id_karton'], 'exist', 'skipOnError' => true, 'targetClass' => Karton::className(), 'targetAttribute' => ['id_karton' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_karton' => 'Id Karton',
            'id_kemas' => 'Id Kemas',
            'code_karton' => 'Code Karton',
            'is_active' => 'Aktif',
            'is_sample' => 'Sample',
            'is_sold' => 'Sold',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKarton()
    {
        return $this->hasOne(Karton::className(), ['id' => 'id_karton']);
    }
}
