<?php

use yii\db\Migration;

/**
 * Handles the creation for table `package`.
 */
class m160725_072616_create_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%package}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%package}}');
    }
}
