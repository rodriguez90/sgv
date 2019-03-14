<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 04/11/2018
 * Time: 5:35
 */


namespace app\commands;

use Da\User\Command\CreateController;
use yii\base\Module;
use yii\console\ExitCode;

use justcoded\yii2\rbac\commands\RbacController;


class SgvController extends RbacController
{

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->path = '@app/controllers';
    }

    /**
     * @return int
     */
    public function actionGenerateRootUser()
    {
        $createController = new CreateController('create','user');
        $email = 'root@test.com';
        $username = 'root';
        $year = date(strtotime("Y"));
        $password = 'root*2019';
        $role = 'Administrador';

        $createController->actionIndex($email,$username, $password, $role);

        return ExitCode::OK;
    }

    public function actionGeneratePermision()
    {
//        $rbac = new RbacController('my-rbac');
        return $this->actionScan();
    }

    public function actionDefaultAssingPermision()
    {
        // FIXME: Check this
        return ExitCode::OK;
    }


}