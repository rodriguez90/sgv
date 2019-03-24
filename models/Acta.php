<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acta".
 *
 * @property int $id
 * @property int $junta_id
 * @property int $count_elector
 * @property int $count_vote
 * @property int $null_vote
 * @property int $blank_vote
 * @property int $type
 *
 * @property Junta $junta
 * @property Voto[] $votos
 */
class Acta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['junta_id', 'count_elector', 'count_vote', 'null_vote', 'blank_vote', 'type'], 'required'],
            [['junta_id'], 'integer'],
            [['null_vote', 'blank_vote', 'count_elector', 'count_vote'], 'integer', 'min' => 0, 'integerOnly'=>true],
            [['junta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Junta::className(), 'targetAttribute' => ['junta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'junta_id' => 'Junta ID',
            'count_elector' => 'Count Elector',
            'count_vote' => 'Count Vote',
            'null_vote' => 'Null Vote',
            'blank_vote' => 'Blank Vote',
            'type' => 'Type',
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
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['acta_id' => 'id']);
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

    private $_recintoEleccion;
    public function getRecintoEleccion(){
        return $this->junta->recintoEleccion;
    }
}
