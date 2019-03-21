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
            [['recinto_eleccion_id'], 'integer'],
            [['null_vote', 'blank_vote',], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['null_vote', 'blank_vote', 'count_elector', 'count_vote'], 'integer', 'min' => 0, 'integerOnly'=>true],
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
            'count_vote' => 'Cantidad de Votantes',
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


    private $_totalVotosValidosByRole;
    public function getTotalVotosValidosByRole($role) {
        $total = 0;

        foreach ($this->votos as $voto) {
            if($voto->role === $role)
                $total += $voto->vote;
        }

        return $total;
    }

    private $_recintoName;
    public function getRecintoName(){
        return $this->recintoEleccion->getName();
    }

    public function getVotesByRole($role)
    {
        $votes = array_filter($this->votos, function ($vote) use ($role) {
            return $vote->role === $role;
        });

        return $votes;
    }

    public function getRecinto() {
        if($this->recintoEleccion)
        return $this->recintoEleccion->recinto;
    }

    public function getZona() {
        return $this->getRecinto()->zona;
    }

    public function getParroquia() {
        return $this->getZona()->parroquia;
    }

    public function getCanton() {
        return $this->getParroquia()->canton;
    }
}
