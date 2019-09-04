<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "agregasi_header".
 *
 * @property int $id
 * @property string $kode_karton
 * @property string $rand_char
 * @property string $no_nie
 * @property string $no_batch
 * @property string $expired_date
 * @property string $isi
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property AgregasiLine[] $agregasiLines
 */
class Agregasiheader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregasi_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_karton', 'rand_char', 'no_nie', 'no_batch', 'expired_date', 'isi', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['kode_karton', 'isi'], 'string', 'max' => 100],
            [['rand_char'], 'string', 'max' => 10],
            [['no_nie'], 'string', 'max' => 50],
            [['no_batch', 'expired_date'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_karton' => 'Kode Karton',
            'rand_char' => 'Rand Char',
            'no_nie' => 'No Nie',
            'no_batch' => 'No Batch',
            'expired_date' => 'Expired Date',
            'isi' => 'Isi',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgregasiLines()
    {
        return $this->hasMany(AgregasiLine::className(), ['id_agregasi' => 'id']);
    }
}
