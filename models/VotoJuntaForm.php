<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 17/03/2019
 * Time: 0:29
 */

namespace app\models;

use app\models\Junta;
use app\models\Voto;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;


class VotoJuntaForm extends Model
{
    private $_junta;
    private $_votes;

    public function rules()
    {
        return [
            [['Junta'], 'required'],
            [['Votes'], 'safe'],
        ];
    }

    public function afterValidate()
    {
//        if (!Model::validateMultiple($this->getAllModels())) {
//            $this->addError('error', 'Error en los datos'); // add an empty error to prevent saving
//        }
        parent::afterValidate();
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        if (!$this->junta->save()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->saveVotes()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;
    }

    public function saveVotes()
    {
//        $keep = [];
        foreach ($this->votes as $vote) {
            $vote->junta_id = $this->junta->id;
            if (!$vote->save(false)) {
                return false;
            }
//            $keep[] = $voto->id;
        }
//        $query = Voto::find()->andWhere(['junta_id' => $this->junta->id]);
//        if ($keep) {
//            $query->andWhere(['not in', 'id', $keep]);
//        }
//        foreach ($query->all() as $voto) {
//            $voto->delete();
//        }
        return true;
    }

    public function getJunta()
    {
        return $this->_junta;
    }

    public function setJunta($junta)
    {
        if ($junta instanceof Junta) {
            $this->_junta= $junta;
        } else if (is_array($junta)) {
            $this->_junta->setAttributes($junta);
        }
    }

    public function getVotes()
    {
        if ($this->_votes === null) {
            $this->_votes = $this->junta->isNewRecord ? [] : $this->junta->votos;
        }
        return $this->_votes;
    }

    private function getVote($key)
    {
        $vote = $key && strpos($key, 'new') === false ? Voto::findOne($key) : false;
        if (!$vote) {
            $vote = new Voto();
            $vote->loadDefaultValues();
        }
        return $vote;
    }

    public function setVotes($votes)
    {
        unset($votes['__id__']); // remove the hidden "new Vote" row
        $this->_votes = [];
        foreach ($votes as $key => $vote) {
            if (is_array($vote)) {
                $this->_votes[$key] = $this->getVote($key);
                $this->_votes[$key]->setAttributes($vote);
            } elseif ($vote instanceof Voto) {

                if($vote->isNewRecord) {
                    $this->_votes[$vote->postulacion_id] = $vote;
                    $this->_votes[$vote->postulacion_id]->setAttributes($vote);
                }
                else {
                    $this->_votes[$vote->id] = $vote;
                    $this->_votes[$vote->id]->setAttributes($vote);
                }
            }
        }
    }

    public function loadVotes()
    {
        $postulaciones = Postulacion::find()->all();
        $votos = [];

        foreach ($postulaciones as $p) {
            $newVote = null;
            if($this->_junta->isNewRecord)
            {
                $newVote = new Voto();
                $newVote->junta_id = $this->_junta->id;
                $newVote->vote = 0;
                $newVote->postulacion_id = $p->id;
            }
            else {
                $newVote = Voto::find()
                    ->andWhere(['junta_id'=>$this->_junta->id])
                    ->andWhere(['postulacion_id'=>$p->id])
                    ->one();
            }

            $newVote->user_id = Yii::$app->user->id;

            array_push($votos, $newVote);
        }

        $this->setVotes($votos);
    }

    public function errorSummary($form)
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            $errorList = $form->errorSummary($model, [
                'header' => '<p>Por favor verifique el siguiente error <b>' . $id . '</b></p>',
            ]);
            $errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
            $errorLists[] = $errorList;
        }
        return implode('', $errorLists);
    }

    private function getAllModels()
    {
        $models = [
            'Junta' => $this->junta,
        ];
        foreach ($this->votes as $id => $vote) {
            $models['Voto.' . $id] = $this->votes[$id];
        }
        return $models;
    }
}