<?php

use yii\db\Migration;

/**
 * Handles the creation for table `order`.
 */
class m160809_062156_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->integer()->notNull(),
            'menu_package_id' => $this->integer()->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'amount' => $this->money()->notNull(),
            'total' => $this->money()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-order-transaction_id',
            '{{%order}}',
            'transaction_id',
            '{{%transaction}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-order-menu_package_id',
            '{{%order}}',
            'menu_package_id',
            '{{%menu_package}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-order-created_by',
            '{{%order}}',
            'created_by',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-order-updated_by',
            '{{%order}}',
            'updated_by',
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
        $this->dropForeignKey('fk-order-updated_by', '{{%order}}');
        $this->dropForeignKey('fk-order-created_by', '{{%order}}');
        $this->dropForeignKey('fk-order-menu_package_id', '{{%order}}');
        $this->dropForeignKey('fk-order-transaction_id', '{{%order}}');
        $this->dropTable('{{%order}}');
    }
}
