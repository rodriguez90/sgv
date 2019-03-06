<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zona".
 *
 * @property int $id
 * @property int $parroquia_id
 * @property string $name
 *
 * @property RecintoElectoral[] $recintoElectorals
 * @property Parroquia $parroquia
 */
class Zona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parroquia_id', 'name'], 'required'],
            [['parroquia_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parroquia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parroquia::className(), 'targetAttribute' => ['parroquia_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'parroquia_id' => 'Parroquia',
            'name' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoElectorals()
    {
        return $this->hasMany(RecintoElectoral::className(), ['zona_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParroquia()
    {
        return $this->hasOne(Parroquia::className(), ['id' => 'parroquia_id']);
    }

    public function getProvince()
    {
        return $this->parroquia->canton->province;
    }

    public function getCanton()
    {
        return $this->parroquia->canton;
    }

    public function getTotalElectores($eleccionId=null)
    {
        $count  = RecintoEleccion::find()
            ->joinWith('recinto')
            ->innerJoin('zona', 'recinto_electoral.zona_id=zona.id')
            ->where(['zona.id'=>$this->id])
            ->andFilterWhere(['eleccion_id'=>$eleccionId])->sum('count_elector');
        return $count;
    }

    public function getTotalRecintos($eleccionId=null)
    {
        $count  = RecintoEleccion::find()
            ->joinWith('recinto')
            ->innerJoin('zona', 'recinto_electoral.zona_id=zona.id')
            ->where(['zona.id'=>$this->id])
            ->andFilterWhere(['eleccion_id'=>$eleccionId])
            ->count('recinto_eleccion.id');
        return $count;
    }

    public function getJuntasMujeres($eleccionId=null){
        $count  = RecintoEleccion::find()
            ->joinWith('recinto')
            ->innerJoin('zona', 'recinto_electoral.zona_id=zona.id')
            ->where(['zona.id'=>$this->id])
            ->andFilterWhere(['eleccion_id'=>$eleccionId])->sum('jr_woman');
        return $count;
    }

    public function getJuntasHombres($eleccionId=null){
        $count  = RecintoEleccion::find()
            ->joinWith('recinto')
            ->innerJoin('zona', 'recinto_electoral.zona_id=zona.id')
            ->where(['zona.id'=>$this->id])
            ->andFilterWhere(['eleccion_id'=>$eleccionId])->sum('jr_man');
        return $count;
    }

    public function getTotalJuntas($eleccionId=null){
        return $this->getJuntasHombres($eleccionId) + $this->getJuntasMujeres($eleccionId);
    }
}
