<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Junta;

/**
 * JuntaSearch represents the model behind the search form of `app\models\Junta`.
 */
class JuntaSearch extends Junta
{
    public $recintoEleccion;
    public $canton;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recinto_eleccion_id', 'null_vote', 'blank_vote', 'type', 'count_elector', 'count_vote'], 'integer'],
            [['name', 'recintoEleccion', 'canton'], 'safe'],
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
        $query = Junta::find();

        // add conditions that should always apply here

        $query->joinWith(['recintoEleccion']);

        $query->innerJoin('recinto_electoral', 'recinto_electoral.id=recinto_eleccion.recinto_id');
        $query->innerJoin('zona', 'zona.id=recinto_electoral.zona_id');
        $query->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id');
        $query->innerJoin('canton', 'canton.id=parroquia.canton_id');
        $query->orderBy([
            'canton.name'=>SORT_ASC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['recintoEleccion'] = [
            'asc'=>['recintoEleccion.name' => SORT_ASC],
            'desc'=>['recintoEleccion.name'=> SORT_DESC] ,
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
            'junta.id' => $this->id,
            'junta.type' => $this->type,
            'null_vote' => $this->null_vote,
            'blank_vote' => $this->blank_vote,
            'count_elector' => $this->count_elector,
            'count_vote' => $this->count_vote,
        ]);

//        var_dump($this->recintoEleccion);die;

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['recinto_eleccion.id' => $this->recintoEleccion]);
        $query->andFilterWhere(['canton.id' => $this->canton]);

        return $dataProvider;
    }
}
