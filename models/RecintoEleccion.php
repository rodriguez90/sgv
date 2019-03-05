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
 * @property Persona $coordinatorJrMan
 * @property Persona $coordinatorJrWoman
 * @property Eleccion $eleccion
 * @property RecintoElectoral $recinto
 * @property Voto[] $votos
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
            'recinto_id' => 'Recinto',
            'coordinator_jr_man' => 'Coordinator JR Hombres',
            'coordinator_jr_woman' => 'Coordinator JR Mujeres',
            'eleccion_id' => 'Elección',
            'jr_woman' => 'Jr Mujeres',
            'jr_man' => 'Jr Hombres',
            'count_elector' => 'Electores',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['recinto_eleccion_id' => 'id']);
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
}
