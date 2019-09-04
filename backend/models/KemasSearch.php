<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Kemas;

/**
 * KemasSearch represents the model behind the search form of `backend\models\Kemas`.
 */
class KemasSearch extends Kemas
{
    /**
     * {@inheritdoc}
     */
    public $nama_produk;
    public $no_batch;
    public $no_nie;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['id_kemas', 'id_karton', 'nama_produk', 'no_batch', 'no_nie'], 'safe'],
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
        $query = Kemas::find();
        $query->joinWith('karton');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (empty($this->id_kemas) and empty($this->id_karton)){
            $query->where('0=1');
            return $dataProvider;
        }
//        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
//            return $dataProvider;
//        }
        
//        $dataProvider->sort->attributes['nama_produk'] = [
//            'asc' => ['karton.nama_produk' => SORT_ASC],
//            'desc' => ['karton.nama_produk' => SORT_DESC],
//        ];
        
        $dataProvider->setSort([
            'attributes' => [
                'id_karton' => [
                    'asc' => ['karton.id_karton' => SORT_ASC],
                    'desc' => ['karton.id_karton' => SORT_DESC]
                ],
                'id_kemas',
                'nama_produk' => [
                    'asc' => ['karton.nama_produk' => SORT_ASC],
                    'desc' => ['karton.nama_produk' => SORT_DESC]
                ],
                'no_batch' => [
                    'asc' => ['karton.no_batch' => SORT_ASC],
                    'desc' => ['karton.no_batch' => SORT_DESC]
                ],
                'no_nie' => [
                    'asc' => ['karton.no_nie' => SORT_ASC],
                    'desc' => ['karton.no_nie' => SORT_DESC]
                ],
            ],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'id_karton' => $this->id_karton,
        ]);

        $query->andFilterWhere(['like', 'id_kemas', $this->id_kemas])
              ->andFilterWhere(['like', 'karton.id_karton', $this->id_karton])
              ->andFilterWhere(['like', 'karton.nama_produk', $this->nama_produk])
              ->andFilterWhere(['like', 'karton.no_batch', $this->no_batch])
              ->andFilterWhere(['like', 'karton.no_nie', $this->no_nie]);

        return $dataProvider;
    }
    
    public function searchDus($params)
    {
        $query = Kemas::find();
        $query->joinWith('karton');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
//             uncomment the following line if you do not want to return any records when validation fails
//             $query->where('0=1');
            return $dataProvider;
        }
        
//        $dataProvider->sort->attributes['nama_produk'] = [
//            'asc' => ['karton.nama_produk' => SORT_ASC],
//            'desc' => ['karton.nama_produk' => SORT_DESC],
//        ];
        
        $dataProvider->setSort([
            'attributes' => [
                'id_karton' => [
                    'asc' => ['karton.id_karton' => SORT_ASC],
                    'desc' => ['karton.id_karton' => SORT_DESC]
                ],
                'id_kemas',
                'nama_produk' => [
                    'asc' => ['karton.nama_produk' => SORT_ASC],
                    'desc' => ['karton.nama_produk' => SORT_DESC]
                ],
                'no_batch' => [
                    'asc' => ['karton.no_batch' => SORT_ASC],
                    'desc' => ['karton.no_batch' => SORT_DESC]
                ],
                'no_nie' => [
                    'asc' => ['karton.no_nie' => SORT_ASC],
                    'desc' => ['karton.no_nie' => SORT_DESC]
                ],
            ],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'id_karton' => $this->id_karton,
        ]);

        $query->andFilterWhere(['like', 'id_kemas', $this->id_kemas])
              ->andFilterWhere(['like', 'karton.id_karton', $this->id_karton])
              ->andFilterWhere(['like', 'karton.nama_produk', $this->nama_produk])
              ->andFilterWhere(['like', 'karton.no_batch', $this->no_batch])
              ->andFilterWhere(['like', 'karton.no_nie', $this->no_nie]);

        return $dataProvider;
    }
    
    public function searchLaporan($params)
    {
        $query = Kemas::find();
        $query->joinWith('karton');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if (empty($this->nama_produk) and empty($this->no_batch)) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        
        $dataProvider->setSort([
            'attributes' => [
                'id_karton' => [
                    'asc' => ['karton.id_karton' => SORT_ASC],
                    'desc' => ['karton.id_karton' => SORT_DESC]
                ],
                'id_kemas',
                'nama_produk' => [
                    'asc' => ['karton.nama_produk' => SORT_ASC],
                    'desc' => ['karton.nama_produk' => SORT_DESC]
                ],
                'no_batch' => [
                    'asc' => ['karton.no_batch' => SORT_ASC],
                    'desc' => ['karton.no_batch' => SORT_DESC]
                ],
                'no_nie' => [
                    'asc' => ['karton.no_nie' => SORT_ASC],
                    'desc' => ['karton.no_nie' => SORT_DESC]
                ],
            ],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'id_kemas', $this->id_kemas])
              ->andFilterWhere(['like', 'karton.id_karton', $this->id_karton])
              ->andFilterWhere(['like', 'karton.nama_produk', $this->nama_produk])
              ->andFilterWhere(['like', 'karton.no_batch', $this->no_batch])
              ->andFilterWhere(['like', 'karton.no_nie', $this->no_nie]);

        return $dataProvider;
    }
}
