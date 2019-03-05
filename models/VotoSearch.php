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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recinto_eleccion_id', 'postulacion_id', 'v_jr_man', 'v_jr_woman', 'vn_jr_man', 'vn_jr_woman', 'vb_jr_man', 'vb_jr_woman'], 'integer'],
            [['recintoEleccion', 'postulacion'], 'safe'],
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
        $query->joinWith(['postulacion', 'recintoEleccion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['postulacion'] = [
            'asc'=>['postulacion.name' => SORT_ASC],
            'desc'=>['postulacion.name'=> SORT_DESC] ,
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
            'id' => $this->id,
            'recinto_eleccion_id' => $this->recinto_eleccion_id,
            'postulacion_id' => $this->postulacion_id,
            'v_jr_man' => $this->v_jr_man,
            'v_jr_woman' => $this->v_jr_woman,
            'vn_jr_man' => $this->vn_jr_man,
            'vn_jr_woman' => $this->vn_jr_woman,
            'vb_jr_man' => $this->vb_jr_man,
            'vb_jr_woman' => $this->vb_jr_woman,
        ]);

        return $dataProvider;
    }
}
