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
}
