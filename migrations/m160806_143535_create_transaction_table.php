<?php

use yii\db\Migration;

/**
 * Handles the creation for table `transaction`.
 */
class m160806_143535_create_transaction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'package_item_id' => $this->integer()->notNull(),
            'firstname' => $this->string(25)->notNull(),
            'lastname' => $this->string(25)->notNull(),
            'contact' => $this->string(50)->notNull(),
            'email' => $this->string(150)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'quantity_of_guest' => $this->smallInteger()->notNull(),
            'check_in' => $this->integer()->notNull(),
            'check_out' => $this->integer(),
            'total_amount' => $this->money(),
            'address' => $this->string(150),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-transaction-package-item_id',
            '{{%transaction}}',
            'package_item_id',
            '{{%package_item}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-transaction-package-item_id', '{{%transaction}}');
        $this->dropTable('{{%transaction}}');
    }
}
