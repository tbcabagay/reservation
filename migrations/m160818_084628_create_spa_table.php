<?php

use yii\db\Migration;

/**
 * Handles the creation of table `spa`.
 */
class m160818_084628_create_spa_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%spa}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'amount' => $this->money()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%spa}}');
    }
}
