<?php

use yii\db\Migration;

/**
 * Handles the creation for table `reservation`.
 */
class m160802_030228_create_reservation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%reservation}}', [
            'id' => $this->primaryKey(),
            'package_item_id' => $this->integer()->notNull(),
            'firstname' => $this->string(25)->notNull(),
            'lastname' => $this->string(25)->notNull(),
            'contact' => $this->string(50)->notNull(),
            'email' => $this->string(150)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'check_in' => $this->date()->notNull(),
            'check_out' => $this->date()->notNull(),
            'quantity_of_guest' => $this->smallInteger()->notNull(),
            'remark' => $this->text(),
            'address' => $this->string(150),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-reservation-package-item_id',
            '{{%reservation}}',
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
        $this->dropForeignKey('fk-reservation-package-item_id', '{{%reservation}}');
        $this->dropTable('{{%reservation}}');
    }
}
