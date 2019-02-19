<?php

namespace app\models;

use Yii;

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
 * @property Voto[] $votos
 */
class Postulacion extends \yii\db\ActiveRecord
{
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
            'id' => 'ID',
            'partido_id' => 'Partido ID',
            'candidate_id' => 'Candidate ID',
            'eleccion_id' => 'Eleccion ID',
            'role' => 'Role',
        ];
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
}
