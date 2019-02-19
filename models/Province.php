<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $id
 * @property string $name
 *
 * @property Canton[] $cantons
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCantons()
    {
        return $this->hasMany(Canton::className(), ['province_id' => 'id']);
    }
}
