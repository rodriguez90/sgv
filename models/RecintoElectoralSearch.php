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
    public $canton;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'zona_id'], 'integer'],
            [['name', 'address', 'zona', 'canton'], 'safe'],
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
        $query->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id');
        $query->innerJoin('canton', 'canton.id=parroquia.canton_id');
        $query->orderBy([
            'canton.name'=>SORT_ASC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['zona'] = [
            'asc'=>['zona.name' => SORT_ASC],
            'desc'=>['zona.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['canton'] = [
            'asc'=>['canton.name' => SORT_ASC],
            'desc'=>['canton.name'=> SORT_DESC] ,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'recinto_electoral.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'recinto_electoral.name', $this->name])
            ->andFilterWhere(['like', 'recinto_electoral.address', $this->address])
            ->andFilterWhere(['zona.id'=> $this->zona])
            ->andFilterWhere(['canton.id'=> $this->canton]);

        return $dataProvider;
    }
}
