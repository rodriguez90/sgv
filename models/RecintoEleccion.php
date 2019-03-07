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
            'id' => 'ID',
            'recinto_id' => 'Recinto ID',
            'coordinator_jr_man' => 'Coordinator Jr Man',
            'coordinator_jr_woman' => 'Coordinator Jr Woman',
            'eleccion_id' => 'Eleccion ID',
            'jr_woman' => 'Jr Woman',
            'jr_man' => 'Jr Man',
            'count_elector' => 'Count Elector',
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
    public function getVotos()
    {
        return Voto::find()
            ->joinWith('junta')
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->where(['recinto_eleccion.id'=>$this->id])
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

    public function getTotalVotos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->vote;
        }

        return $total;
    }

    public function getTotalVotosMujeres() {
        $votos = $this->votos;
        $total = 0;

//        foreach ($votos as $voto) {
//            $total +=
//                $voto->v_jr_woman +
//                $voto->vn_jr_woman +
//                $voto->vb_jr_woman ;
//        }

        return $total;
    }

    public function getTotalVotosHombres() {
        $votos = $this->votos;
        $total = 0;

//        foreach ($votos as $voto) {
//            $total += $voto->v_jr_man +
//                $voto->vn_jr_man +
//                $voto->vb_jr_man;
//        }

        return $total;
    }

    public function getTotalVotosNulos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->null_vote;
        }

        return $total;
    }


    public function getTotalVotosBlancos() {
        $votos = $this->votos;
        $total = 0;

        foreach ($votos as $voto) {
            $total += $voto->blank_vote;
        }

        return $total;
    }

    public function getAusentismo() {
        $totalVotos = $this->getTotalVotos();

        return $this->count_elector - $totalVotos;
    }

    public function getPorcientoAusentismo() {
        $ausentismo = $this->getAusentismo();

        $porciento = ($ausentismo * 100 )/ $this->count_elector;

        return $porciento;
    }
}
