<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Voto;

/**
 * VotoSearch represents the model behind the search form of `app\models\Voto`.
 */
class VotoSearch extends Voto
{
    public $postulacion;
    public $recintoEleccion;
    public $junta;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'postulacion_id', 'acta_id', 'vote', 'user_id'], 'integer'],
            [['postulacion', 'recintoEleccion', 'junta'], 'safe'],
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
        $query = Voto::find();

        // add conditions that should always apply here

        $query->joinWith(['postulacion', 'acta']);
        $query->innerJoin('junta', 'junta.id=acta.junta_id');
        $query->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id');
        $query->innerJoin('recinto_electoral', 'recinto_electoral.id=recinto_eleccion.recinto_id');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['postulacion'] = [
            'asc'=>['postulacion.name' => SORT_ASC],
            'desc'=>['postulacion.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['junta'] = [
            'asc'=>['junta.name' => SORT_ASC],
            'desc'=>['junta.name'=> SORT_DESC] ,
        ];

        $dataProvider->sort->attributes['recintoEleccion'] = [
            'asc'=>['recintoEleccion.name' => SORT_ASC],
            'desc'=>['recintoEleccion.name'=> SORT_DESC] ,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'voto.id' => $this->id,
            'postulacion_id' => $this->postulacion_id,
            'acta_id' => $this->acta_id,
            'vote' => $this->vote,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'postulacion.name', $this->postulacion]);
        $query->andFilterWhere(['like', 'junta.name', $this->junta]);
        $query->andFilterWhere(['like', 'recintoEleccion.name', $this->recinto]);

        return $dataProvider;
    }
}
