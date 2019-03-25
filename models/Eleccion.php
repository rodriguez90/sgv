<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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

    public function getTotalJuntas()
    {
        $count  = Junta::find()
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->where(['eleccion_id'=>$this->id])
            ->count('junta.id');
        return $count;
    }

    public function getTotalActas()
    {
        $count  = Acta::find()
            ->innerJoin('junta', 'junta.id=acta.junta_id')
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->where(['eleccion_id'=>$this->id])
            ->count('acta.id');
        return $count;
    }

    public function getTotalActasRegistradas()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(
                "select COUNT(t.id) as total from (
                    select acta.id, SUM(voto.vote) + acta.blank_vote + acta.null_vote  as cantidad
                    from acta
                    inner Join voto on voto.acta_id=acta.id
                    inner Join junta on junta.id=acta.junta_id
                    inner Join recinto_eleccion on recinto_eleccion.id=junta.recinto_eleccion_id
                    where recinto_eleccion.eleccion_id=:eleccionId
                    GROUP BY acta.id
                    HAVING cantidad > 0) as t", [':eleccionId' =>  $this->id]);

        $result = $command->queryAll();

        return $result[0]['total'];
    }

    public function getActasRegistradas()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(
            "select t.id as total from (
                    select acta.id, SUM(voto.vote) + acta.blank_vote + acta.null_vote  as cantidad
                    from acta
                    inner Join voto on voto.acta_id=acta.id
                    inner Join junta on junta.id=acta.junta_id
                    inner Join recinto_eleccion on recinto_eleccion.id=junta.recinto_eleccion_id
                    where recinto_eleccion.eleccion_id=:eleccionId
                    GROUP BY acta.id
                    HAVING cantidad > 0) as t", [':eleccionId' =>  $this->id]);

        $actas = $command->queryColumn();

        return $actas;
    }

    public function getTotalPostulacion()
    {
        $count  = Postulacion::find()
            ->where(['eleccion_id'=>$this->id])->count('postulacion.id');
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
            $total += $r->totalVotosValidos ;
        }
        return $total;
    }

    private $_porcientoVotos;
    public function getPorcientoVotos() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = round(($this->totalVotos * 100 )/ $this->totalElectores, 2);

        return $porciento;
    }

    private $_porcientoVotosValidos;
    public function getPorcientoVotosValidos() {
        $porciento = 0;
        if(intval($this->totalElectores) > 0)
            $porciento = round(($this->totalVotosValidos * 100 )/ $this->totalElectores, 2);

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
            $porciento = round(($this->totalVotosNulos * 100 )/ $this->totalElectores, 2);

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
            $porciento = round(($this->totalVotosBlancos * 100 )/ $this->totalElectores, 2);

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
