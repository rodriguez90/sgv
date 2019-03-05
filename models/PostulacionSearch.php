<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Postulacion;

/**
 * PostulacionSearch represents the model behind the search form of `app\models\Postulacion`.
 */
class PostulacionSearch extends Postulacion
{
    public $partido;
    public $candidate;
    public $eleccion;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'partido_id', 'candidate_id', 'eleccion_id', 'role'], 'integer'],
            [['partido', 'candidate', 'eleccion'], 'safe'],
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
        $query = Postulacion::find();

        // add conditions that should always apply here

        $query->joinWith(['partido', 'candidate', 'eleccion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['partido'] = [
            'asc'=>['partido.name' => SORT_ASC],
            'desc'=>['partido.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['candidate'] = [
            'asc'=>['candidate.name' => SORT_ASC],
            'desc'=>['candidate.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['eleccion'] = [
            'asc'=>['eleccion.name' => SORT_ASC],
            'desc'=>['eleccion.name'=> SORT_DESC] ,
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'postulacion.id' => $this->id,
//            'partido_id' => $this->partido_id,
//            'candidate_id' => $this->candidate_id,
//            'eleccion_id' => $this->eleccion_id,
            'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'partido.name', $this->partido]);
        $query->andFilterWhere(['like', 'eleccion.name', $this->eleccion]);
        $query->andFilterWhere(['like', 'candidate.name', $this->candidate]);

        return $dataProvider;
    }
}
