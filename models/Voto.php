<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voto".
 *
 * @property int $id
 * @property int $recinto_eleccion_id
 * @property int $postulacion_id
 * @property int $v_jr_man
 * @property int $v_jr_woman
 * @property int $vn_jr_man
 * @property int $vn_jr_woman
 * @property int $vb_jr_man
 * @property int $vb_jr_woman
 *
 * @property Postulacion $postulacion
 * @property RecintoEleccion $recintoEleccion
 */
class Voto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recinto_eleccion_id', 'postulacion_id', 'v_jr_man', 'v_jr_woman', 'vn_jr_man', 'vn_jr_woman', 'vb_jr_man', 'vb_jr_woman'], 'required'],
            [['recinto_eleccion_id', 'postulacion_id', 'v_jr_man', 'v_jr_woman', 'vn_jr_man', 'vn_jr_woman', 'vb_jr_man', 'vb_jr_woman'], 'integer'],
            [['postulacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postulacion::className(), 'targetAttribute' => ['postulacion_id' => 'id']],
            [['recinto_eleccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecintoEleccion::className(), 'targetAttribute' => ['recinto_eleccion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No.',
            'recinto_eleccion_id' => 'Recinto Electoral',
            'postulacion_id' => 'Postulación',
            'v_jr_man' => 'VJR Hombres',
            'v_jr_woman' => 'VJR Mujeres',
            'vn_jr_man' => 'VN JR Hombres',
            'vn_jr_woman' => 'VN JR Mujeres',
            'vb_jr_man' => 'VN JR Hombres',
            'vb_jr_woman' => 'VN JR Mujeres',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacion()
    {
        return $this->hasOne(Postulacion::className(), ['id' => 'postulacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecintoEleccion()
    {
        return $this->hasOne(RecintoEleccion::className(), ['id' => 'recinto_eleccion_id']);
    }
}
