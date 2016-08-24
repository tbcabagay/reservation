<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m160824_151544_create_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->integer()->notNull(),
            'spa_id' => $this->integer()->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'amount' => $this->money()->notNull(),
            'total' => $this->money()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-service-transaction_id',
            '{{%service}}',
            'transaction_id',
            '{{%transaction}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-service-spa_id',
            '{{%service}}',
            'spa_id',
            '{{%spa}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-service-created_by',
            '{{%service}}',
            'created_by',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-service-updated_by',
            '{{%service}}',
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
        $this->dropForeignKey('fk-service-transaction_id', '{{%service}}');

        $this->dropForeignKey('fk-service-spa_id', '{{%service}}');

        $this->dropForeignKey('fk-service-created_by', '{{%service}}');

        $this->dropForeignKey('fk-service-updated_by', '{{%service}}');

        $this->dropTable('{{%service}}');
    }
}
