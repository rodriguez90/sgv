<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $gender
 *
 * @property RecintoEleccion[] $recintoEleccions
 * @property RecintoEleccion[] $recintoEleccions0
 */
class Persona extends \yii\db\ActiveRecord
{

    const GENDER_M = 'F';
    const GENDER_F = 'M';

    const GENDER_CHOICES = [
        ['id' => 'F', 'name' => 'Feminia'],
        ['id' => 'M', 'name' => 'Masculina'],
    ];

    const GENDER_LABEL = [
        'F' => 'Feminia',
        'M' => 'Masculina',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone_number'], 'required'],
            [['first_name', 'last_name', 'phone_number'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Nombre',
            'last_name' => 'Apellidos',
            'phone_number' => 'Télefono',
            'gender' => 'Género',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccions()
    {
        return $this->hasMany(RecintoEleccion::className(), ['coordinator_jr_man' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccions0()
    {
        return $this->hasMany(RecintoEleccion::className(), ['coordinator_jr_woman' => 'id']);
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name ;
    }
}
