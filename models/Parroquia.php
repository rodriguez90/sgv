<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parroquia".
 *
 * @property int $id
 * @property int $canton_id
 * @property string $name
 *
 * @property Canton $canton
 * @property Zona[] $zonas
 */
class Parroquia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parroquia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['canton_id', 'name'], 'required'],
            [['canton_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['canton_id'], 'exist', 'skipOnError' => true, 'targetClass' => Canton::className(), 'targetAttribute' => ['canton_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'canton_id' => 'Cantón',
            'name' => 'Nombre',
        ];
    }

    public function getProvince()
    {
        return $this->canton->province;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCanton()
    {
        return $this->hasOne(Canton::className(), ['id' => 'canton_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonas()
    {
        return $this->hasMany(Zona::className(), ['parroquia_id' => 'id']);
    }

    public function getTotalElectores($eleccionId=null)
    {
        $zonas  = $this->zonas;
        $count = 0;
        foreach ($zonas as $zona)
        {
            $count += $zona->getTotalElectores($eleccionId);
        }
        return $count;
    }

    public function getTotalRecintos($eleccionId=null)
    {
        $zonas  = $this->zonas;
        $count = 0;
        foreach ($zonas as $zona)
        {
            $count += $zona->getTotalRecintos($eleccionId);
        }
        return $count;
    }

    public function getJuntasMujeres($eleccionId=null){
        $zonas  = $this->zonas;
        $count = 0;
        foreach ($zonas as $zona)
        {
            $count += $zona->getJuntasMujeres($eleccionId);
        }
        return $count;
    }

    public function getJuntasHombres($eleccionId=null){
        $zonas  = $this->zonas;
        $count = 0;
        foreach ($zonas as $zona)
        {
            $count += $zona->getJuntasHombres($eleccionId);
        }
        return $count;
    }

    public function getTotalJuntas($eleccionId=null){
        return $this->getJuntasHombres($eleccionId) + $this->getJuntasMujeres($eleccionId);
    }
}
