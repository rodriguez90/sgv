<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eleccion".
 *
 * @property int $id
 * @property string $name
 * @property string $delivery_date
 *
 * @property Postulacion[] $postulacions
 * @property RecintoEleccion[] $recintoEleccions
 */
class Eleccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eleccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['delivery_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'name' => 'Nombre',
            'delivery_date' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacions()
    {
        return $this->hasMany(Postulacion::className(), ['eleccion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccions()
    {
        return $this->hasMany(RecintoEleccion::className(), ['eleccion_id' => 'id']);
    }

    private $_totalElectores = 0;
    /**
     * @return mixed
     */
    public function getTotalElectores()
    {
        $count  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->sum('count_elector');
        if($count == null) $count = 0;
        return $count;
    }

    public function getTotalRecintos()
    {
        $count  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->count('recinto_eleccion.id');
        return $count;
    }

    private $_totalVotos = 0;
    public function getTotalVotos()
    {
        $total = 0;
        $recintos  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->all();
        foreach ($recintos as $r)
        {
            $total += $r->totalVotos;
        }
        return $total;
    }

    private $_totalVotosValidos = 0;
    public function getTotalVotosValidos()
    {
        $total = 0;
        $recintos  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->all();
        foreach ($recintos as $r)
        {
            $total += $r->totalVotos;
        }
        return $total;
    }

    private $_porcientoVotos;
    public function getPorcientoVotos() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = ($this->totalVotos * 100 )/ $this->totalElectores;

        return $porciento;
    }

    private $_totalVotosNulos = 0;
    public function getTotalVotosNulos()
    {
        $total = 0;
        $recintos  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->all();
        foreach ($recintos as $r)
        {
            $total += $r->totalVotosNulos;
        }
        return $total;
    }

    private $_porcientoVotosNulos;
    public function getPorcientoVotosNulos() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = ($this->totalVotosNulos * 100 )/ $this->totalElectores;

        return $porciento;
    }

    private $_totalVotosBlancos = 0;
    public function getTotalVotosBlancos()
    {
        $total = 0;
        $recintos  = RecintoEleccion::find()->where(['eleccion_id'=>$this->id])->all();
        foreach ($recintos as $r)
        {
            $total += $r->totalVotosBlancos;
        }
        return $total;
    }

    private $_porcientoVotosBlancos;
    public function getPorcientoVotosBlancos() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = ($this->totalVotosBlancos * 100 )/ $this->totalElectores;

        return $porciento;
    }

    private $_ausentismo = 0;
    public function getAusentismo () {
        $this->_ausentismo = $this->totalElectores - $this->totalVotos;
        return $this->_ausentismo;
    }

    private $_porcientoAusentismo = 0;
    public function getPorcientoAusentismo() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = round(($this->ausentismo * 100 )/ $this->totalElectores, 2);

        return $porciento;
    }
}
