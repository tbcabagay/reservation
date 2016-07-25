<?php

use yii\db\Migration;

/**
 * Handles the creation for table `package_item`.
 */
class m160725_073036_create_package_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%package_item}}', [
            'id' => $this->primaryKey(),
            'package_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'content' => $this->text()->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'rate' => $this->money()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-package_item-package_id',
            '{{%package_item}}',
            'package_id',
            '{{%package}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-package_item-package_id',
            '{{%package_item}}'
        );

        $this->dropTable('{{%package_item}}');
    }
}
