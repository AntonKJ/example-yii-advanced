<?php

use yii\db\Migration;

class m210623_181442_url_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%url_status}}', [

            'hash_string' => $this->string(32)->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'url' => $this->string(255)->notNull(),
            'status_code' => $this->integer()->notNull(),
            'query_count' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->addPrimaryKey('pk_hash_string', 'url_status', ['hash_string']);

    }

    public function down()
    {
        $this->dropTable('{{%url_status}}');
    }
}
