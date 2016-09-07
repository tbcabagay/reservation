<?php

use yii\db\Migration;

/**
 * Handles the creation for table `hits`.
 */
class m160907_011217_create_hits_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%hits}}', [
            'hit_id' => $this->primaryKey(),
            'user_agent' => $this->string()->notNull(),
            'ip' => $this->string()->notNull(),
            'target_group' => $this->string()->notNull(),
            'target_pk' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%hits}}');
    }
}
