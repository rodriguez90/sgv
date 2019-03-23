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
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;


class VotoJuntaForm extends Model
{
    private $_junta;
    private $_votes;
    private $_actas;

    public function rules()
    {
        return [
            [['Junta'], 'required'],
            [['Actas', 'Votes'], 'safe'],
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

        if (!$this->saveActas()) {
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

    public function saveActas(){
        $keep = [];
        foreach ($this->actas as $acta) {
            $acta->junta_id = $this->junta->id;
            if (!$acta->save(false)) {
                return false;
            }
            $keep[] = $acta->id;
        }
        if(!$this->junta->isNewRecord)
        {
            $query = Acta::find()->andWhere(['junta_id' =>$this->junta->id]);
            if ($keep) {
                $query->andWhere(['not in', 'id', $keep]);
            }
            foreach ($query->all() as $acta) {
                $acta->delete();
            }
            return true;
        }
    }

    public function saveVotes()
    {
        foreach ($this->_actas as $acta)
        {
//            $keep = [];
            $votos = $this->getVotesByRole($acta->type);
            foreach ($votos as $vote) {
                $vote->acta_id = $acta->id;
               try {
                   if (!$vote->save(false)) {
                       return false;
                   }
               }
               catch (\Exception $e) {
                   var_dump($vote->postulacion_id);die;
                   return false;

                }
//                $keep[] = $vote->id;
            }
//            $query = Voto::find()->andWhere(['acta_id' =>$acta->id]);
//            if ($keep) {
//                $query->andWhere(['not in', 'id', $keep]);
//            }
//            foreach ($query->all() as $voto) {
//                $voto->delete();
//            }
        }

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

    public function getActas()
    {
        if ($this->_actas === null) {
            $this->_actas = $this->junta->isNewRecord ? [] : $this->junta->actas;
        }
        return $this->_actas;
    }

    public function setActas($actas)
    {
        unset($actas['__id__']); // remove the hidden "new Acta" row
        $this->_actas = [];
        foreach ($actas as $key => $acta) {
            if (is_array($acta)) {
                $this->_actas[$key] = new Acta();
                $this->_actas[$key]->loadDefaultValues();
                $this->_actas[$key]->setAttributes($acta);
            } elseif ($acta instanceof Acta) {
                if($acta->isNewRecord) {
                    $this->_actas[$acta->type] = $acta;
                }
                else {
                    $this->_actas[$acta->id] = $acta;
                }
            }
        }
    }

    public function getVotes()
    {
        if ($this->_votes === null) {
            $this->_votes = $this->junta->isNewRecord ? [] : $this->junta->votos;
        }
        return $this->_votes;
    }

    private function getActa($key)
    {
        $acta = $key && strpos($key, 'new') === false ? Acta::findOne($key) : false;
        if (!$acta) {
            $acta = new Acta();
            $acta->loadDefaultValues();
        }
        return $acta;
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

    public function getVotesByRole($role)
    {
        $votes = array_filter($this->_votes, function ($vote) use ($role) {
            return array_filter($vote, function ($vote) use ($role) {
                    return $vote->role == $role;
            });
        });

        return $votes[$role];
    }

    public function setVotes($rolesVotes)
    {
        unset($rolesVotes['__id__']); // remove the hidden "new Vote" row
        $this->_votes = [];

        foreach ($rolesVotes as $role => $votes) {
//            var_dump($role);
//            var_dump($votes);die;
            foreach ($votes as $key => $vote) {
//                var_dump($vote);die;
                if (is_array($vote)) {
//                    $this->_votes[$role][$key] = $this->getVote($key);
                    if($vote->postulacion_id == null)
                        var_dump($vote->postulacion_id);die('setVotes');
                    $this->_votes[$role][$key] = new Voto();
                    $this->_votes[$role][$key]->loadDefaultValues();
                    $this->_votes[$role][$key]->setAttributes($vote);
                } elseif ($vote instanceof Voto) {

                    if($vote->isNewRecord) {
                        $this->_votes[$role][$vote->postulacion_id] = $vote;
                    }
                    else {
                        $this->_votes[$role][$vote->id] = $vote;
                    }
                }
            }
        }
    }

    public function loadVotes()
    {

        // canton relacionado a traves del recinto con la junta
        $canton = $this->_junta->getCanton();

        // roles o dignidades de acuerdo a las postulaciones que estan relacionado con el canton
        $roles = Postulacion::find()
            ->select('postulacion.role')
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id=postulacion.id')
            ->where(['postulacion_canton.canton_id'=> $canton->id])
            ->groupBy(['postulacion.role'])
            ->asArray()
            ->all();

        $actas = [];
        $votos = [];

        foreach ($roles as $role)
        {
            $roleId = intval($role['role']);
            $acta = new Acta();
            $acta->junta_id = $this->_junta->id;
            $acta->count_elector = 0;
            $acta->count_vote = 0;
            $acta->null_vote = 0;
            $acta->blank_vote = 0;
            $acta->type = $roleId;

            if(!$this->_junta->isNewRecord)
            {
                $oldActa= Acta::find() // se asume q solo se tendra un acta por tipo de rol
                    ->andWhere(['junta_id'=>$this->_junta->id])
                    ->andWhere(['type'=>$roleId])
                    ->one();

                if($oldActa)
                {
                    $acta = $oldActa;
                }
            }

            $votos[$roleId] = []; // arreglo de votos por tipo de acta

            // postulaciones por canton y roles (actas)
            $postulaciones = Postulacion::find()
                ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id=postulacion.id')
                ->where(['postulacion_canton.canton_id'=> $canton->id])
                ->where(['postulacion.role'=> $roleId])
                ->all();

            foreach ($postulaciones as $p) {
                $vote = new Voto();
                $vote->acta_id = $acta->id;
                $vote->vote = 0;
                $vote->postulacion_id = $p->id;

                if(!$acta->isNewRecord)
                {
                    $oldVote = Voto::find()
                        ->andWhere(['acta_id'=>$acta->id])
                        ->andWhere(['postulacion_id'=>$p->id])
                        ->one();

                    if($oldVote)
                    {
                        $vote = $oldVote;
                    }
                }

                $vote->user_id = Yii::$app->user->id;

                array_push($votos[$roleId], $vote);
            }

            array_push($actas, $acta);
        }

        $this->setActas($actas);

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
        foreach ($this->actas as $id => $acta) {
            $models['Acta.' . $id] = $this->actas[$id];
        }
        foreach ($this->votes as $id => $vote) {
            $models['Voto.' . $id] = $this->votes[$id];
        }
        return $models;
    }

    public function getActaByRole($role){
        foreach ($this->actas as $acta) {
            if($acta->type == $role);
            return $acta;
        }
        return null;
    }

    public function setAttributes($data) {
        $this->_junta->setAttributes($data["Junta"]);
        $this->setActas($data["Actas"]);

        $votesData = $data["Votes"];

        $votes = [];

        foreach ($votesData as $voteData) {
            if($voteData['postulacion_id'] == null ||
                $voteData['postulacion_id'] == '')
            {
//                var_dump($voteData);die('setAttributes');
            }
            $votes[$voteData['role']][] = $voteData;
        }

        $this->setVotes($votes);
    }
}