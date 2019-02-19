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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'gender' => 'Gender',
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
}
