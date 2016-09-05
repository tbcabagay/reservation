<?php

use yii\db\Migration;

/**
 * Handles the creation for table `menu_item`.
 */
class m160807_141857_create_menu_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_package_id' => $this->integer()->notNull(),
            'menu_category_id' => $this->integer()->notNull(),
            'title' => $this->string(30)->notNull(),
            'description' => $this->string(50),
            'photo' =>  $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-menu_item-menu_package_id',
            '{{%menu_item}}',
            'menu_package_id',
            '{{%menu_package}}',
            'id',
            'RESTRICT',
        );

        $this->addForeignKey(
            'fk-menu_item-menu_category_id',
            '{{%menu_item}}',
            'menu_category_id',
            '{{%menu_category}}',
            'id',
            'RESTRICT',
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-menu_item-menu_category_id', '{{%menu_item}}');
        $this->dropForeignKey('fk-menu_item-menu_package_id', '{{%menu_item}}');
        $this->dropTable('{{%menu_item}}');
    }
}
