<?php
namespace backend\controllers;

use backend\models\AurlStatus;
use Yii;
use yii\base\BaseObject;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class CheckstatusController extends ActiveController
{
    /**
     * @var string
     * @description Api example url http://backend.localhost/checkstatus get all urls list
     * Вот так REST API нашего сервиса сейчас включает в себя:

        GET /urls: получение постранично списка всех URL адресов;
        HEAD /urls: получение метаданных листинга URL адресов;
        POST /urls: создание нового URL адреса;
        GET /urls/123: получение информации по конкретному URL адресу с id равным 123;
        HEAD /urls/123: получение метаданных по конкретному URL адресу с id равным 123;
        PATCH /urls/123 и PUT /urls/123: изменение информации по URL адресу с id равным 123;
        DELETE /urls/123: удаление URL адреса с id равным 123;
        OPTIONS /urls: получение поддерживаемых методов, по которым можно обратится к /urls;
        OPTIONS /urls/123: получение поддерживаемых методов, по которым можно обратится к /urls/123.

        Пробуем получить ответы по API используя curl:

        curl -i -H "Accept:application/json" "http://backend.localhost/checkstatus"
        HTTP/1.1 200 OK
        Server: nginx/1.13.12
        Date: Thu, 24 Jun 2021 06:23:50 GMT
        Content-Type: application/json; charset=UTF-8
        Transfer-Encoding: chunked
        Connection: keep-alive
        X-Powered-By: PHP/7.4.20
        Vary: Accept

        [{"url":"https://example.com/page/test"}]

     *
     */

    public $modelClass = 'backend\models\AurlStatus';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        //unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider(){

        $result = $this->getArrayAllUrls();

        return [ 'url' => ArrayHelper::getColumn($result, 'url')];

    }

    public function getArrayAllCompared(){

        return $this->modelClass::find()
            ->select(['url', 'status_code'])
            ->where(['!=', 'url', ''])
            ->all();
    }

    public function getArrayAllUrls(){

        return $this->modelClass::find()
            ->select(['url', 'query_count'])
            ->where(['!=', 'url', ''])
            ->all();
    }

    public function getArrayOnHash ($hash_string) {
        return ArrayHelper::getColumn($this->modelClass::find()
            ->select(['hash_string'])
            ->where(['like', 'hash_string', $hash_string . '%', false])
            ->all(), 'hash_string');
    }

    public function saveUpdates($data_save) {
        foreach ($data_save as $data_save_item) {
            if ( count($this->getArrayOnHash(md5($data_save_item['url']))) == 0 ) {
                // var_dump($this->getArrayOnHash(md5($data_save_item['url'])));
                $model = new AurlStatus();
                $model->url = $data_save_item['url'];
                $model->status_code = $data_save_item['status'];
                $model->query_count = $data_save_item['query_count'];
                $model->hash_string = md5($data_save_item['url']);
                $model->save();
            } else {
                \Yii::$app->db->createCommand()->update('url_status',
                    ['status_code' => $data_save_item['status'],
                     'url' => $data_save_item['url'],
                     'query_count' => $data_save_item['query_count'],
                      'updated_at' => time(),
                     ],
                ['hash_string' => md5($data_save_item['url'])])
                    ->execute();
            }
        }
        \Yii::$app->getResponse()->redirect('/checkstatus/result-is-compared');
    }

    public function actionResultIsCompared () {

        $result = $this->getArrayAllCompared();

        return [ 'codes' => $result ];
    }

    public function actionRestCheckUrls() {

/*        var_dump(\Yii::$app->request->get()["aurl"]);
        exit();*/

        if (isset(\Yii::$app->request->get()["aurl"])){
            $urls = [ 'url' => \Yii::$app->request->get()["aurl"] ];
            $query_count = [ 'query_count' =>  0 ];
        } else {
            $urls = ArrayHelper::getColumn($this->getArrayAllUrls(), 'url');
            $query_count = ArrayHelper::getColumn($this->getArrayAllUrls(), 'query_count');
        }
        $urls_data = [];
        $i = 0;
        foreach ($urls as $url ){
            $urls_data[$i]['url'] = $url;
            $urls_data[$i]['status'] = $this->curlTest($url)['status'];
            $urls_data[$i]['time'] = $this->curlTest($url)['time'];
            $i++;
        }

        $iq = 0;
        foreach ($query_count as $count) {
            $urls_data[$iq]['query_count'] = $count + 1;
            $iq++;
        }
        $this->saveUpdates($urls_data);
        //var_dump($urls_data);
    }

    public function curlTest($url) {
        error_reporting(0);
        // Создаём дескриптор cURL
        $ch = curl_init((string)$url);

        // Запускаем
        curl_exec($ch);

        // Проверяем наличие ошибок
        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            //echo 'Прошло ', $info['total_time'], ' секунд во время запроса к ', $info['url'], "\n";
        }

        $result= [];

        // Проверяем наличие ошибок
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:
                    $result['status'] = 200;
                    break;
                default:
                    $result['status'] = $http_code;
                    //echo 'Неожиданный код HTTP: ', $http_code, "\n";
            }
        }

        $result['time'] = $info['total_time'] ?? '';

        if (isset($info) && $info['total_time'] > 5) {
            $result['status'] = 0;
        }

        // Закрываем дескриптор
        curl_close($ch);

        return $result;
    }
}