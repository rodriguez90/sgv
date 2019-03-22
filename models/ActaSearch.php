<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Acta;

/**
 * ActaSearch represents the model behind the search form of `app\models\Acta`.
 */
class ActaSearch extends Acta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'junta_id', 'count_elector', 'count_vote', 'null_vote', 'blank_vote', 'type'], 'integer'],
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
        $query = Acta::find();

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
            'junta_id' => $this->junta_id,
            'count_elector' => $this->count_elector,
            'count_vote' => $this->count_vote,
            'null_vote' => $this->null_vote,
            'blank_vote' => $this->blank_vote,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
