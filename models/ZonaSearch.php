<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Zona;

/**
 * ZonaSearch represents the model behind the search form of `app\models\Zona`.
 */
class ZonaSearch extends Zona
{
    public $canton;
    public $province;
    public $parroquia;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parroquia_id'], 'integer'],
            [['name', 'canton', 'province', 'parroquia'], 'safe'],
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
        $query = Zona::find();

        // add conditions that should always apply here
        $query->joinWith('parroquia');
        $query->innerJoin('canton', 'parroquia.canton_id=canton.id');
        $query->innerJoin('province', 'canton.province_id=province.id');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['parroquia'] = [
            'asc'=>['parroquia.name' => SORT_ASC],
            'desc'=>['parroquia.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['canton'] = [
            'asc'=>['canton.name' => SORT_ASC],
            'desc'=>['canton.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['province'] = [
            'asc'=>['province.name' => SORT_ASC],
            'desc'=>['province.name'=> SORT_DESC] ,
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
            'parroquia_id' => $this->parroquia_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'parroquia.name', $this->parroquia]);
        $query->andFilterWhere(['like', 'canton.name', $this->canton]);
        $query->andFilterWhere(['like', 'province.name', $this->province]);

        return $dataProvider;
    }
}
