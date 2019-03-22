<?php

namespace app\models;

use Yii;
use app\models\Acta;

/**
 * This is the model class for table "junta".
 *
 * @property int $id
 * @property int $recinto_eleccion_id
 * @property string $name
 * @property int $type
 *
 * @property RecintoEleccion $recintoEleccion
 * @property Actas[] $actas
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
            [['recinto_eleccion_id', 'name', 'type'], 'required'],
            [['recinto_eleccion_id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActas()
    {
//        $canton = $this->getCanton();
//        $query = $this->hasMany(Voto::className(), ['junta_id' => 'id']);
//        $query
//            ->innerJoin('postulacion', 'postulacion.id=voto.postulacion_id')
//            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id=postulacion.id')
//            ->where(['postulacion_canton.canton_id'=> $canton->id]);

        return $this->hasMany(Acta::className(), ['junta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccion()
    {
        return $this->hasOne(RecintoEleccion::className(), ['id' => 'recinto_eleccion_id']);
    }

   private $_votos;
    public function getVotos()
    {
        $this->_votos = [];
        foreach ($this->actas as $acta)
        {
            $this->_votos[] = $acta->votos;
        }

        return  $this->_votos;
    }

    private $_totalVotos;
    public function getTotalVotos() {
        $total = 0;

        foreach ($this->actas as $acta) {
            $total += $acta->totalVotos;
        }

        return $total;
    }

    private $_totalVotosValidos;
    public function getTotalVotosValidos() {
        $total = 0;

        foreach ($this->actas as $acta) {
            $total += $acta->totalVotosValidos;
        }

        return $total;
    }

    private $_totalVotosNulos;
    public function getTotalVotosNulos() {
        $this->_totalNullVote = 0;

        foreach ($this->actas as $acta) {
            $this->_totalNullVote += $acta->null_vote ;
        }

        return $this->_totalNullVote;
    }

    private $_totalVotosBlancos;
    public function getTotalVotosBlancos() {
        $this->_totalVotosBlancos = 0;

        foreach ($this->actas as $acta) {
            $this->_totalVotosBlancos += $acta->blank_vote ;
        }

        return $this->_totalVotosBlancos;
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

    public function getActasByRole($role)
    {
        $actas = array_filter($this->actas, function ($acta) use ($role) {
            return $acta->type === $role;
        });

        return $actas;
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
