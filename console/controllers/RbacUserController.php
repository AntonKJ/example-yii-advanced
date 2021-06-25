<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacUserController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем роль "user"
        $user = $auth->createRole('user');
        $auth->add($user);

        // добавляем роль "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);
    }

}
// uncomment //'class' => 'mdm\admin\models\User', in common/config/main
# For create roles in to RBAC you need enter of terminal this line > php yii rbac-user/init