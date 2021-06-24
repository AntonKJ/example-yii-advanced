<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

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
class AurlStatus extends \yii\db\ActiveRecord
{

    protected $hash_string;
    protected $created_at;
    protected $updated_at;
    protected $query_count;

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
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */

    public function afterSave($insert, $changedAttributes)
    {
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
