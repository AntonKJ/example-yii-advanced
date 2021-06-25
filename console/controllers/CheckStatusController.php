<?php
namespace console\controllers;

use common\models\UrlStatus;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\db\Expression;

class CheckStatusController extends Controller
{
    /**
     *

        php yii check-status/statistics

        {"codes":[{"url":"https:\/\/example.com\/page\/test","status_code":"404"}]}

        Done!

     *
     */

    public function actionStatistics()
    {
        $class = new UrlStatus();

        // вывод за последние 24 часа со статусом неравным 200
        $result = $class->find()
             ->select(['url', 'status_code'])
             ->where(['!=', 'status_code', '200'])
             ->andWhere(['>=', 'updated_at', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
             ->asArray()
             ->all();

        //Выводим сообщение об успехе и возвращаем соответствующий код
        $this->stdout( json_encode([ 'codes' => $result ]
            )."\nDone!\n", Console::BOLD);
        return ExitCode::OK;
    }

}
