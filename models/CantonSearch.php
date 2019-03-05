<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Canton;

/**
 * CantonSearch represents the model behind the search form of `app\models\Canton`.
 */
class CantonSearch extends Canton
{
    public $province;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'type'], 'integer'],
            [['name', 'province'], 'safe'],
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
        $query = Canton::find();

        // add conditions that should always apply here

        $query->joinWith('province');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'canton.id' => $this->id,
//            'province_id' => $this->province_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'province.name', $this->province]);

        return $dataProvider;
    }
}
