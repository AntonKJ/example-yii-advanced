<?php
namespace console\controllers;

use common\models\UrlStatus;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class CheckStatusController extends Controller
{

    public $modelClass = 'backend\models\AurlStatus';

    public function actionStatistics()
    {
        $class = new UrlStatus();

        $result = $class->find()
             ->select(['url', 'status_code'])
             ->where(['=', 'status_code', '200'])
             ->asArray()
             ->all();

        //Выводим сообщение об успехе и возвращаем соответствующий код
        $this->stdout( json_encode([ 'codes' => $result ]
            )."\nDone!\n", Console::BOLD);
        return ExitCode::OK;
    }

}