<?php

namespace app\models;

use Yii;
use Da\User\Model\Profile;

/**
 * This is the model class for table "postulacion".
 *
 * @property int $id
 * @property int $partido_id
 * @property int $candidate_id
 * @property int $eleccion_id
 * @property int $role
 *
 * @property Profile $candidate
 * @property Eleccion $eleccion
 * @property Partido $partido
 * @property PostulacionCanton[] $postulacionCantons
 * @property Voto[] $votos
 */
class Postulacion extends \yii\db\ActiveRecord
{
    const ROL_ALCALDIA = 1;
    const ROL_PREFECTURA = 2;
    const ROL_CONSEJAL_URBANO = 3;
    const ROL_CONSEJAL_RURAL = 4;
    const ROL_VOCAL_JUNTAP_PARROQUIAL = 5;
    const CONCEJAR_URBANO_POR_CIRCUNSCRIPCION = 6;

    const ROL_CHOICES = [
        ['id' => 1, 'name' => 'Alcaldía'],
        ['id' => 2, 'name' => 'Prefectura'],
        ['id' => 3, 'name' => 'Consejal_Urbano'],
        ['id' => 4, 'name' => 'Consejal_Rular'],
        ['id' => 5, 'name' => 'Vocal_Junta_Parroquial'],
        ['id' => 6, 'name' => 'Concejal_Urbano_Por_Circonscripcion']
    ];

    const ROL_LABEL = [
        1 => 'Alcaldía',
        2 => 'Prefectura',
        3 => 'Consejal_Urbano',
        4 => 'Consejal_Rural',
        5 => 'Vocal_Junta_Parroquial',
        6 => 'Concejal_Urbano_Por_Circonscripcion'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postulacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partido_id', 'candidate_id', 'eleccion_id', 'role'], 'required'],
            [['partido_id', 'candidate_id', 'eleccion_id', 'role'], 'integer'],
            [['candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['candidate_id' => 'user_id']],
            [['eleccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eleccion::className(), 'targetAttribute' => ['eleccion_id' => 'id']],
            [['partido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partido::className(), 'targetAttribute' => ['partido_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'partido_id' => 'Partido',
            'candidate_id' => 'Candidato',
            'eleccion_id' => 'Elección',
            'role' => 'Rol',
            'postulacionCantons' => 'Cantones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacionCantons()
    {
        return $this->hasMany(PostulacionCanton::className(), ['postulacion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'candidate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEleccion()
    {
        return $this->hasOne(Eleccion::className(), ['id' => 'eleccion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartido()
    {
        return $this->hasOne(Partido::className(), ['id' => 'partido_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['postulacion_id' => 'id']);
    }

    private $_totalVotos;
    public function getTotalVotos() {
        $this->_totalVotos = 0;

        foreach ($this->votos as $voto)
        {
            $this->_totalVotos += $voto->vote;
        }

        return $this->_totalVotos;
    }

    private $_name;
    public function getName(){
//        $name = $this->partido->name .
//                ' - ' . $this->partido->list .
//                ' - ' . $this->partido->number .
//                ' - '.  $this->candidate->name  .
//                ' - ' . Postulacion::ROL_LABEL[$this->role];

        $this->_name = $this->candidate->name .
            ' - ' . Postulacion::ROL_LABEL[$this->role];

        return $this->_name;
    }

}
