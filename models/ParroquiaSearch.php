<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parroquia;

/**
 * ParroquiaSearch represents the model behind the search form of `app\models\Parroquia`.
 */
class ParroquiaSearch extends Parroquia
{
    public $canton;
    public $province;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'canton_id', 'type'], 'integer'],
            [['name', 'canton', 'province'], 'safe'],
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
        $query = Parroquia::find();

        // add conditions that should always apply here

        $query->joinWith('canton');
        $query->innerJoin('province', 'canton.province_id=province.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'parroquia.id' => $this->id,
            'canton_id' => $this->canton_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'canton.name', $this->canton]);
        $query->andFilterWhere(['like', 'province.name', $this->province]);

        return $dataProvider;
    }
}
