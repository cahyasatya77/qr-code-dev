<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Karton;
use yii\db\Query;

/**
 * KartonSearch represents the model behind the search form of `backend\models\Karton`.
 */
class KartonSearch extends Karton
{
    /**
     * {@inheritdoc}
     */
    public $groupname;
    public $produk;
    
    public function rules()
    {
        return [
            [['id', 'last_updated_by'], 'integer'],
            [['id_karton', 'nama_produk', 'deskripsi', 'no_nie', 'no_batch', 'tanggal_produksi', 'tanggal_ed', 'created_at', 'last_updated_date','groupname','produk'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Karton::find()->select([
            '{{karton}}.*',
            '{{kemas}}.id_kemas AS id_kemas'
        ])->joinWith('kemas');
//        $query->joinWith(['produk' => function($query){
//                return $query->from('coba_product_management_2.'.Produk::tableName());
//        }])->all();
        $query->joinWith('produk')->all();
//        $data = new Query();
//        $data->select([
//            'karton.id_karton as id_karton',
//            'kemas.id_kemas as kemas',
//            'produk.nama_produk as produk',
//        ])->from('karton')
//        ->join('LEFT JOIN', 'kemas',
//                'karton.id = kemas.id_karton')
//        ->join('LEFT JOIN', 'coba_product_management_2.tbl_produk produk',
//                'karton.nama_produk = produk.kd_produk');
//
//        $command = $data->createCommand();
//        $query = $command->queryAll();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
//        $dataProvider->sort->attributes['kemas'] = [
//            'asc' => ['kemas.id_kemas' => SORT_ASC],
//            'desc' => ['kemas.id_kemas' => SORT_DESC],
//        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_produksi' => $this->tanggal_produksi,
            'tanggal_ed' => $this->tanggal_ed,
            'last_updated_by' => $this->last_updated_by,
            'created_at' => $this->created_at,
            'last_updated_date' => $this->last_updated_date,
        ]);

        $query->andFilterWhere(['like', 'id_karton', $this->id_karton])
//            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'tanggal_ed', $this->tanggal_ed])
            ->andFilterWhere(['like', 'kemas.id_kemas', $this->groupname])
            ->andFilterWhere(['like', 'coba_product_management_2.tbl_produk.nama_produk', $this->nama_produk]);

        return $dataProvider;
    }
    
    public function searchSold($params)
    {
        $query = Karton::find();
        $query->joinWith('kemas')->where(['is_sold' => 'TRUE']);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_produksi' => $this->tanggal_produksi,
            'YEAR(`tanggal_ed`)' => $this->tanggal_ed,
            'last_updated_by' => $this->last_updated_by,
            'created_at' => $this->created_at,
            'last_updated_date' => $this->last_updated_date,
        ]);

        $query->andFilterWhere(['like', 'karton.id_karton', $this->id_karton])
            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'kemas.id_kemas', $this->groupname]);

        return $dataProvider;
    }
    
    public function searchReturn($params)
    {
        $query = Karton::find();
        $query->joinWith('kemas')->where(['is_sold' => 'FALSE']);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_produksi' => $this->tanggal_produksi,
            'YEAR(`tanggal_ed`)' => $this->tanggal_ed,
            'last_updated_by' => $this->last_updated_by,
            'created_at' => $this->created_at,
            'last_updated_date' => $this->last_updated_date,
        ]);

        $query->andFilterWhere(['like', 'karton.id_karton', $this->id_karton])
            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'kemas.id_kemas', $this->groupname]);

        return $dataProvider;
    }
    
    public static function getYearsList()
    {
        $years = (new Query())->select('DISTINCT YEAR(`tanggal_ed`) as years')->from('{{karton}}')->column();
        return array_combine($years, $years);
    }
}
