<?php

use yii\db\Migration;

/**
 * Handles the creation for table `menu_item`.
 */
class m160807_140631_create_menu_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%menu_category}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(30)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu_category}}');
    }
}
