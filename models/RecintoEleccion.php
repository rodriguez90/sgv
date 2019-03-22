<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recinto_eleccion".
 *
 * @property int $id
 * @property int $recinto_id
 * @property int $coordinator_jr_man
 * @property int $coordinator_jr_woman
 * @property int $eleccion_id
 * @property int $jr_woman
 * @property int $jr_man
 * @property int $count_elector
 *
 * @property Junta[] $juntas
 * @property Persona $coordinatorJrMan
 * @property Persona $coordinatorJrWoman
 * @property Eleccion $eleccion
 * @property RecintoElectoral $recinto
 */
class RecintoEleccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recinto_eleccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recinto_id', 'coordinator_jr_man', 'coordinator_jr_woman', 'eleccion_id'], 'required'],
            [['recinto_id', 'coordinator_jr_man', 'coordinator_jr_woman', 'eleccion_id', 'jr_woman', 'jr_man', 'count_elector'], 'integer'],
            [['coordinator_jr_man'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['coordinator_jr_man' => 'id']],
            [['coordinator_jr_woman'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['coordinator_jr_woman' => 'id']],
            [['eleccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eleccion::className(), 'targetAttribute' => ['eleccion_id' => 'id']],
            [['recinto_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecintoElectoral::className(), 'targetAttribute' => ['recinto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'recinto_id' => 'Recinto',
            'coordinator_jr_man' => 'Coordinador Junta Hombres',
            'coordinator_jr_woman' => 'Coordinador Junta Mujeres',
            'eleccion_id' => 'Elección',
            'jr_woman' => 'JM',
            'jr_man' => 'JH',
            'count_elector' => 'Cantidad de Electores',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJuntas()
    {
        return $this->hasMany(Junta::className(), ['recinto_eleccion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinatorJrMan()
    {
        return $this->hasOne(Persona::className(), ['id' => 'coordinator_jr_man']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinatorJrWoman()
    {
        return $this->hasOne(Persona::className(), ['id' => 'coordinator_jr_woman']);
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
    public function getRecinto()
    {
        return $this->hasOne(RecintoElectoral::className(), ['id' => 'recinto_id']);
    }

    private $_votos=[];

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos($juntaTipo = null)
    {
        return Voto::find()
            ->joinWith('acta')
            ->innerJoin('junta', 'junta.id=acta.junta_id')
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->where(['recinto_eleccion.id'=>$this->id])
            ->andFilterWhere(['junta.type'=>$juntaTipo])
            ->all();
    }

    private $_totalJuntas;

    public function getTotalJuntas(){
        $name = $this->jr_man + $this->jr_woman;

        return $name;
    }

    private $_parroquia;
    public function getParroquia(){
        return $this->getZona()->parroquia;
    }
    private $_zona;
    public function getZona(){
        return $this->recinto->zona;

    }

    private $_name;
    public function getName(){
        $name = $this->recinto->name;

        return $name;
    }

    private $_totalVotos;
    public function getTotalVotos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->vote;
        }

        return $total;
    }

    public function getTotalVotosMujeres() {
        $votos = $this->getVotos(Junta::JUNTA_MUJER);
        $total = 0;

        foreach ($votos as $voto) {
            $total +=  $voto->vote;
        }

        return $total;
    }

    public function getTotalVotosHombres() {
        $votos = $this->getVotos(Junta::JUNTA_HOMBRE);
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->vote;
        }

        return $total;
    }

    private $_totalVotosNulos = 0;
    public function getTotalVotosNulos() {
        $juntas = $this->juntas;
        $total = 0;

        foreach ($juntas as $junta) {
            $total += $junta->null_vote;
        }

        return $total;
    }

    private $_totalVotosBlancos=0;
    public function getTotalVotosBlancos() {
        $juntas = $this->juntas;
        $total = 0;

        foreach ($juntas as $junta) {
            $total += $junta->blank_vote;
        }

        return $total;
    }

    private $_ausentismo;
    public function getAusentismo() {
        $totalVotos = $this->getTotalVotos();

        return $this->count_elector - $totalVotos;
    }

    private $_porcientoAusentismo;
    public function getPorcientoAusentismo() {
        $ausentismo = $this->getAusentismo();

        $porciento = 0;
        if(intval($this->count_elector) > 0)
            $porciento = ($ausentismo * 100 )/ $this->count_elector;

        return $porciento;
    }
}
