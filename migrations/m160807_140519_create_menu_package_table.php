<?php

use yii\db\Migration;

/**
 * Handles the creation for table `menu_package`.
 */
class m160807_140519_create_menu_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%menu_package}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'amount' => $this->money()->notNull(),
            'unit' => $this->string(20)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu_package}}');
    }
}
