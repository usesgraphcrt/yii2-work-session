<?php

use yii\db\Schema;
use yii\db\Migration;

class m160705_061313_Mass extends Migration {

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        else {
            $tableOptions = null;
        }
        
        $connection = Yii::$app->db;

        try {
            $this->createTable('{{%work_session}}', [
                'id' => Schema::TYPE_PK . "",
                'start' => Schema::TYPE_DATETIME . " NOT NULL",
                'stop' => Schema::TYPE_DATETIME . "",
                'report' => Schema::TYPE_TEXT . "",
                'start_timestamp' => Schema::TYPE_INTEGER . "(11)",
                'stop_timestamp' => Schema::TYPE_INTEGER . "(11)",
                ], $tableOptions);

            $this->createTable('{{%work_session_user}}', [
                'id' => Schema::TYPE_PK . "",
                'start' => Schema::TYPE_DATETIME . " NOT NULL",
                'stop' => Schema::TYPE_DATETIME . " NOT NULL",
                'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'report' => Schema::TYPE_TEXT . "",
                'start_timestamp' => Schema::TYPE_INTEGER . "(11)",
                'stop_timestamp' => Schema::TYPE_INTEGER . "(11)",
                ], $tableOptions);

        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

    public function safeDown() {
        $connection = Yii::$app->db;
        try {
            $this->dropTable('{{%work_session}}');
            $this->dropTable('{{%work_session_user}}');
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

}
