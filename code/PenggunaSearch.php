<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pengguna;

/**
 * PenggunaSearch represents the model behind the search form about `app\models\Pengguna`.
 */
class PenggunaSearch extends Pengguna {
    
    public $namaJabatan, $namaBahagian, $namaUnit;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nama_pengguna', 'nama_penuh', 'namaJabatan', 'namaBahagian', 'namaUnit'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Pengguna::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'nama_pengguna',
                'nama_penuh',
                'status',
                'namaJabatan' => [
                    'asc' => ['jabatan.nama_jabatan' => SORT_ASC],
                    'desc' => ['jabatan.nama_jabatan' => SORT_DESC],
                    'label' => 'Jabatan'
                ],
                'namaBahagian' => [
                    'asc' => ['bahagian.nama_bahagian' => SORT_ASC],
                    'desc' => ['bahagian.nama_bahagian' => SORT_DESC],
                    'label' => 'Bahagian'
                ],
                'namaUnit' => [
                    'asc' => ['unit.nama_unit' => SORT_ASC],
                    'desc' => ['unit.nama_unit' => SORT_DESC],
                    'label' => 'Unit'
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nama_pengguna', $this->nama_pengguna]);
        $query->andFilterWhere(['like', 'nama_penuh', $this->nama_penuh]);

        // filter by Jabatan
        $query->joinWith(['jabatan' => function ($q) {
                $q->where('jabatan.nama_jabatan LIKE "%' . $this->namaJabatan . '%"');
            }]);
            
        // filter by Bahagian
        $query->joinWith(['bahagian' => function ($q) {
                $q->where('bahagian.nama_bahagian LIKE "%' . $this->namaBahagian . '%"');
            }]);
            
        // filter by Unit
        $query->joinWith(['unit' => function ($q) {
                $q->where('unit.nama_unit LIKE "%' . $this->namaUnit . '%"');
            }]);


        return $dataProvider;
    }

}
