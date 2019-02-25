<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recinto_electoral".
 *
 * @property int $id
 * @property int $zona_id
 * @property string $name
 * @property string $address
 *
 * @property RecintoEleccion[] $recintoEleccions
 * @property Zona $zona
 */
class RecintoElectoral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recinto_electoral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zona_id', 'name', 'address'], 'required'],
            [['zona_id'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['zona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['zona_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'zona_id' => 'Zona',
            'name' => 'Nombre',
            'address' => 'Dirección',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccions()
    {
        return $this->hasMany(RecintoEleccion::className(), ['recinto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id']);
    }
}
