<?php
namespace backend\controllers;

use yii\rest\ActiveController;

class UrlController extends ActiveController
{
    /**
     * @var string
     * @description Api example url http://backend.localhost/urls get all urls list
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

        curl -i -H "Accept:application/json" "http://backend.localhost/urls"

        HTTP/1.1 200 OK
        Server: nginx/1.13.12
        Date: Thu, 24 Jun 2021 04:51:07 GMT
        Content-Type: application/json; charset=UTF-8
        Transfer-Encoding: chunked
        Connection: keep-alive
        X-Powered-By: PHP/7.4.20
        Vary: Accept
        X-Pagination-Total-Count: 1
        X-Pagination-Page-Count: 1
        X-Pagination-Current-Page: 1
        X-Pagination-Per-Page: 20
        Link: <http://backend.localhost/urls?url=%2Furls&page=1>; rel=self, <http://backend.localhost/urls?url=%2Furls&page=1>; rel=first, <http://backend.localhost/urls?url=%2Furls&page=1>; rel=last

        [{"hash_string":"d9cd0e536710be2ee669cd0e583330d1","created_at":1624466862,"updated_at":1624466862,"url":"https://example.com/page/test","status_code":200,"query_count":1}]

     *
     */

    public $modelClass = 'common\models\UrlStatus';
}