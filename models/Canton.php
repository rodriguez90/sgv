<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "canton".
 *
 * @property int $id
 * @property int $province_id
 * @property string $name
 *
 * @property Province $province
 * @property Parroquia[] $parroquias
 */
class Canton extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'canton';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id', 'name'], 'required'],
            [['province_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'province_id' => 'Provincia',
            'name' => 'Nombre',
            'provinceName' => 'Provincia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    private $_provinceName;
    public function getProvinceName()
    {
        $province = $this->province;
        return $province ? $province->name : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParroquias()
    {
        return $this->hasMany(Parroquia::className(), ['canton_id' => 'id']);
    }

    public function getTotalElectores($eleccionId=null)
    {
        $parroquias  = $this->parroquias;
        $count = 0;
        foreach ($parroquias as $parroquia)
        {
            $count += $parroquia->getTotalElectores($eleccionId);
        }
        return $count;
    }

    public function getTotalRecintos($eleccionId=null)
    {
        $parroquias  = $this->parroquias;
        $count = 0;
        foreach ($parroquias as $parroquia)
        {
            $count += $parroquia->getTotalRecintos($eleccionId);
        }
        return $count;
    }

    public function getJuntasMujeres($eleccionId=null){
        $parroquias  = $this->parroquias;
        $count = 0;
        foreach ($parroquias as $parroquia)
        {
            $count += $parroquia->getJuntasMujeres($eleccionId);
        }
        return $count;
    }

    public function getJuntasHombres($eleccionId=null){
        $parroquias  = $this->parroquias;
        $count = 0;
        foreach ($parroquias as $parroquia)
        {
            $count += $parroquia->getJuntasHombres($eleccionId);
        }
        return $count;
    }

    public function getTotalJuntas($eleccionId=null){
        return $this->getJuntasHombres($eleccionId) + $this->getJuntasMujeres($eleccionId);
    }
}
