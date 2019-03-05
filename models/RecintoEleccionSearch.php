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
    public $parroquia;
    public $zona;
    public $eleccion;
    public $recinto;
    public $coordinator_jr_man;
    public $coordinator_jr_woman;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recinto_id', 'coordinator_jr_man', 'coordinator_jr_woman', 'eleccion_id', 'jr_woman', 'jr_man', 'count_elector'], 'integer'],
            [['parroquia', 'zona', 'eleccion', 'recinto'], 'safe'],
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
        $query->joinWith(['recinto', 'eleccion']);
        $query->innerJoin('zona', 'zona.id=recinto_electoral.zona_id');
        $query->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id');
        $query->innerJoin('persona', 'persona.id=recinto_eleccion.coordinator_jr_man or persona.id=recinto_eleccion.coordinator_jr_woman');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['recinto'] = [
            'asc'=>['recinto.name' => SORT_ASC],
            'desc'=>['recinto.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['zona'] = [
            'asc'=>['zona.name' => SORT_ASC],
            'desc'=>['zona.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['parroquia'] = [
            'asc'=>['parroquia.name' => SORT_ASC],
            'desc'=>['parroquia.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['eleccion'] = [
            'asc'=>['eleccion.name' => SORT_ASC],
            'desc'=>['eleccion.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['coordinator_jr_man'] = [
            'asc'=>['coordinator_jr_man.last_name' => SORT_ASC],
            'desc'=>['coordinator_jr_man.last_name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['coordinator_jr_woman'] = [
            'asc'=>['coordinator_jr_woman.last_name' => SORT_ASC],
            'desc'=>['coordinator_jr_woman.last_name'=> SORT_DESC] ,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'recinto_eleccion.id' => $this->id,
//            'recinto_id' => $this->recinto_id,
//            'coordinator_jr_man' => $this->coordinator_jr_man,
//            'coordinator_jr_woman' => $this->coordinator_jr_woman,
//            'eleccion_id' => $this->eleccion_id,
            'jr_woman' => $this->jr_woman,
            'jr_man' => $this->jr_man,
            'count_elector' => $this->count_elector,
        ]);

        $query->andFilterWhere(['like', 'parroquia.name', $this->parroquia]);
        $query->andFilterWhere(['like', 'zona.name', $this->zona]);
        $query->andFilterWhere(['like', 'eleccion.name', $this->eleccion]);
        $query->andFilterWhere(['like', 'recinto_electoral.name', $this->recinto]);

        return $dataProvider;
    }
}
