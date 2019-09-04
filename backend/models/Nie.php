<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_nie".
 *
 * @property int $kd_nie
 * @property string $kd_produk
 * @property string $nomor_nie
 * @property string $tgl_terbit
 * @property string $ed
 * @property string $status_ed
 * @property string $warning
 * @property string $tindakan
 * @property string $kemasan
 * @property string $status
 * @property int $last_updated_by
 * @property string $last_updated_date
 *
 * @property TblUser $lastUpdatedBy
 * @property TblProduk $kdProduk
 */
class Nie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_nie';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pm');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_terbit', 'ed', 'warning', 'last_updated_date'], 'safe'],
            [['warning', 'tindakan'], 'required'],
            [['last_updated_by'], 'integer'],
            [['kd_produk'], 'string', 'max' => 10],
            [['nomor_nie'], 'string', 'max' => 30],
            [['status_ed', 'tindakan'], 'string', 'max' => 20],
            [['kemasan'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 1],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => TblUser::className(), 'targetAttribute' => ['last_updated_by' => 'id']],
            [['kd_produk'], 'exist', 'skipOnError' => true, 'targetClass' => TblProduk::className(), 'targetAttribute' => ['kd_produk' => 'kd_produk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_nie' => 'Kd Nie',
            'kd_produk' => 'Kd Produk',
            'nomor_nie' => 'Nomor Nie',
            'tgl_terbit' => 'Tgl Terbit',
            'ed' => 'Ed',
            'status_ed' => 'Status Ed',
            'warning' => 'Warning',
            'tindakan' => 'Tindakan',
            'kemasan' => 'Kemasan',
            'status' => 'Status',
            'last_updated_by' => 'Last Updated By',
            'last_updated_date' => 'Last Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(TblUser::className(), ['id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdProduk()
    {
        return $this->hasOne(TblProduk::className(), ['kd_produk' => 'kd_produk']);
    }
}
