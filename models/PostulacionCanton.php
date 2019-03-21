<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "postulacion_canton".
 *
 * @property int $id
 * @property int $postulacion_id
 * @property int $canton_id
 *
 * @property Canton $canton
 * @property Postulacion $postulacion
 */
class PostulacionCanton extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postulacion_canton';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postulacion_id', 'canton_id'], 'required'],
            [['postulacion_id', 'canton_id'], 'integer'],
            [['canton_id'], 'exist', 'skipOnError' => true, 'targetClass' => Canton::className(), 'targetAttribute' => ['canton_id' => 'id']],
            [['postulacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postulacion::className(), 'targetAttribute' => ['postulacion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postulacion_id' => 'Postulacion ID',
            'canton_id' => 'Canton ID',
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
    public function getPostulacion()
    {
        return $this->hasOne(Postulacion::className(), ['id' => 'postulacion_id']);
    }
}
