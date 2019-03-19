<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "junta".
 *
 * @property int $id
 * @property int $recinto_eleccion_id
 * @property string $name
 * @property int $type
 * @property int $null_vote
 * @property int $blank_vote
 * @property int $count_elector
 * @property int $count_vote
 *
 * @property RecintoEleccion $recintoEleccion
 * @property Voto[] $votos
 */
class Junta extends \yii\db\ActiveRecord
{

    const JUNTA_MUJER = 1;
    const JUNTA_HOMBRE = 2;

    const JUNTA_CHOICES = [
        ['id' => 1, 'name' => 'Junta Mujeres'],
        ['id' => 2, 'name' => 'Junta Hombres']
    ];

    const JUNTA_LABEL = [
        1 => 'Junta Mujeres',
        2 => 'Junta Hombres',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'junta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recinto_eleccion_id', 'name', 'type', 'count_elector', 'count_vote'], 'required'],
            [['recinto_eleccion_id', 'null_vote', 'blank_vote', 'type'], 'integer'],
            [['null_vote', 'blank_vote',], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['recinto_eleccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecintoEleccion::className(), 'targetAttribute' => ['recinto_eleccion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'recinto_eleccion_id' => 'Recinto en Elección',
            'name' => 'Nombre',
            'type' => 'Tipo',
            'null_vote' => 'Votos Nulos',
            'blank_vote' => 'Votos en Blanco',
            'count_elector' => 'Cantidad Electores',
            'count_vote' => 'Cantidad Votos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccion()
    {
        return $this->hasOne(RecintoEleccion::className(), ['id' => 'recinto_eleccion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['junta_id' => 'id']);
    }

    private $_totalVotos;
    public function getTotalVotos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->vote;
        }

        $total += $this->blank_vote + $this->null_vote ;

        return $total;
    }

    private $_totalVotosValidos;
    public function getTotalVotosValidos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->vote;
        }


        return $total;
    }

    private $_recintoName;
    public function getRecintoName(){
        return $this->recintoEleccion->getName();
    }
}
