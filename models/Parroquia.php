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
}
