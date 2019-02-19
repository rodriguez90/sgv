<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecintoEleccion;

/**
 * RecintoEleccionSearch represents the model behind the search form of `app\models\RecintoEleccion`.
 */
class RecintoEleccionSearch extends RecintoEleccion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recinto_id', 'coordinator_jr_man', 'coordinator_jr_woman', 'eleccion_id', 'jr_woman', 'jr_man', 'count_elector'], 'integer'],
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
        $query = RecintoEleccion::find();

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
            'recinto_id' => $this->recinto_id,
            'coordinator_jr_man' => $this->coordinator_jr_man,
            'coordinator_jr_woman' => $this->coordinator_jr_woman,
            'eleccion_id' => $this->eleccion_id,
            'jr_woman' => $this->jr_woman,
            'jr_man' => $this->jr_man,
            'count_elector' => $this->count_elector,
        ]);

        return $dataProvider;
    }
}
