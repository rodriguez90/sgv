<?php

namespace app\models;

use Yii;
use Da\User\Model\User;

/**
 * This is the model class for table "voto".
 *
 * @property int $id
 * @property int $postulacion_id
 * @property int $junta_id
 * @property int $vote
 * @property int $user_id
 *
 * @property Junta $junta
 * @property User $user
 * @property Postulacion $postulacion
 */
class Voto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postulacion_id', 'junta_id', 'vote', 'user_id'], 'required'],
            [['postulacion_id', 'junta_id', 'vote', 'user_id'], 'integer'],
            [['junta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Junta::className(), 'targetAttribute' => ['junta_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['postulacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postulacion::className(), 'targetAttribute' => ['postulacion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'postulacion_id' => 'Postulación',
            'junta_id' => 'Junta',
            'vote' => 'Votos',
            'user_id' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJunta()
    {
        return $this->hasOne(Junta::className(), ['id' => 'junta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacion()
    {
        return $this->hasOne(Postulacion::className(), ['id' => 'postulacion_id']);
    }

    public function getRecintoEleccion(){
        return $this->junta->recintoEleccion;
    }

    public function getRecinto(){
        return $this->junta->recintoEleccion->recinto;
    }

    private $_name;
    public function getName(){
        $name = $this->postulacion->getName();

        return $name;
    }
}
