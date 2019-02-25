<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partido".
 *
 * @property int $id
 * @property string $name
 * @property string $list
 * @property string $number
 *
 * @property Postulacion[] $postulacions
 */
class Partido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'list', 'number'], 'required'],
            [['name', 'list', 'number'], 'string', 'max' => 255],
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
            'list' => 'Lista',
            'number' => 'Número',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacions()
    {
        return $this->hasMany(Postulacion::className(), ['partido_id' => 'id']);
    }
}
