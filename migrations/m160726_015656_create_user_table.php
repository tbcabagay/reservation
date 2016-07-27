<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160726_015656_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(25)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->char(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'registration_ip' => $this->string(45)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-user-username', '{{%user}}', 'username', true);
        $this->createIndex('idx-user-email', '{{%user}}', 'email', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        /*$this->dropIndex('idx-user-username', '{{%user}}');
        $this->dropIndex('idx-user-email', '{{%email}}');*/
        $this->dropTable('{{%user}}');
    }
}
