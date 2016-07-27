<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160727_134618_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'slug' => $this->string(250)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-news-user_id',
            '{{%news}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-news-user_id', '{{%news}}');
        $this->dropTable('{{%news}}');
    }
}
