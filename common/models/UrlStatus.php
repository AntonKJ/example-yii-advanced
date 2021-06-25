<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "url_status".
 *
 * @property int $hash_string
 * @property int $created_at
 * @property int $updated_at
 * @property string $url
 * @property int $status_code
 * @property int $query_count
 */
class UrlStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'url', 'status_code', 'query_count'], 'required'],
            [['created_at', 'updated_at', 'status_code', 'query_count'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hash_string' => 'Hash String',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'url' => 'Url',
            'status_code' => 'Status Code',
            'query_count' => 'Query Count',
        ];
    }
}
