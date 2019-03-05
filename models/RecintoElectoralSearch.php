<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecintoElectoral;

/**
 * RecintoElectoralSearch represents the model behind the search form of `app\models\RecintoElectoral`.
 */
class RecintoElectoralSearch extends RecintoElectoral
{
    public $zona;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'zona_id'], 'integer'],
            [['name', 'address', 'zona'], 'safe'],
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
        $query = RecintoElectoral::find();

        // add conditions that should always apply here

        $query->joinWith('zona');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['zona'] = [
            'asc'=>['zona.name' => SORT_ASC],
            'desc'=>['zona.name'=> SORT_DESC] ,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'zona_id' => $this->zona_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'zona.name', $this->zona]);

        return $dataProvider;
    }
}
