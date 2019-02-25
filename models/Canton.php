<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "canton".
 *
 * @property int $id
 * @property int $province_id
 * @property string $name
 * @property int $type
 *
 * @property Province $province
 * @property Parroquia[] $parroquias
 */
class Canton extends \yii\db\ActiveRecord
{
    const CANTON_RURAL = 1;
    const CANTON_NORTH = 2;
    const CANTON_SOUTH = 3;

    const CANTON_CHOICES = [
        ['id' => 1, 'name' => 'Rural'],
        ['id' => 2, 'name' => 'Norte'],
        ['id' => 3, 'name' => 'Sur']
    ];

    const CANTON_LABEL = [
       1 => 'Rural',
       2 => 'Norte',
       3 => 'Sur'
    ];

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
            [['province_id', 'name', 'type'], 'required'],
            [['province_id', 'type'], 'integer'],
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
            'type' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParroquias()
    {
        return $this->hasMany(Parroquia::className(), ['canton_id' => 'id']);
    }
}
