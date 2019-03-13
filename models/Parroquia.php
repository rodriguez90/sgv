<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parroquia".
 *
 * @property int $id
 * @property int $canton_id
 * @property string $name
 * @property int $type
 *
 * @property Canton $canton
 * @property Zona[] $zonas
 */
class Parroquia extends \yii\db\ActiveRecord
{

    const PARROQUIA_RURAL = 1;
    const PARROQUIA_NORTH = 2;
    const PARROQUIA_SOUTH = 3;

    const PARROQUIA_CHOICES = [
        ['id' => 1, 'name' => 'Rural'],
        ['id' => 2, 'name' => 'Norte'],
        ['id' => 3, 'name' => 'Sur']
    ];

    const PARROQUIA_LABEL = [
        1 => 'Rural',
        2 => 'Norte',
        3 => 'Sur'
    ];

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
            [['canton_id', 'name', 'type'], 'required'],
            [['canton_id', 'type'], 'integer'],
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
            'type' => 'Tipo',
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
