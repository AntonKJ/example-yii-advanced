<?php
namespace console\controllers;

use common\models\UrlStatus;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class CheckStatusController extends Controller
{
    /**
     *

        php yii check-status/statistics

       {"codes":[{"url":"https:\/\/www.google.com\/","status_code":"200"},
       {"url":"https:\/\/www.yiiframework.com\/doc\/api\/2.0\/yii-web-request","status_code":"200"},
       {"url":"https:\/\/www.md5hashgenerator.com\/","status_code":"200"},
       {"url":"https:\/\/github.com\/AntonKJ\/","status_code":"200"}]}

       Done!

     *
     */
    public $modelClass = 'backend\models\AurlStatus';

    public function actionStatistics()
    {
        $class = new UrlStatus();

        $result = $class->find()
             ->select(['url', 'status_code'])
             ->where(['=', 'status_code', '200'])
             ->andWhere(['>=', 'updated_at', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
             ->asArray()
             ->all();

        //Выводим сообщение об успехе и возвращаем соответствующий код
        $this->stdout( json_encode([ 'codes' => $result ]
            )."\nDone!\n", Console::BOLD);
        return ExitCode::OK;
    }

}