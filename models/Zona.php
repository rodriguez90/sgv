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
            'id' => 'ID',
            'parroquia_id' => 'Parroquia ID',
            'name' => 'Name',
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
}
