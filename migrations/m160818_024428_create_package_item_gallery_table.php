<?php

use yii\db\Migration;

/**
 * Handles the creation of table `package_item_gallery`.
 */
class m160818_024428_create_package_item_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%package_item_gallery}}', [
            'id' => $this->primaryKey(),
            'package_item_id' => $this->integer()->notNull(),
            'thumbnail' => $this->string(255)->notNull(),
            'photo' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-package_item_gallery-package_item_id',
            '{{%package_item_gallery}}',
            'package_item_id',
            '{{%package_item}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-package_item_gallery-package_item_id', '{{%package_item_gallery}}');
        $this->dropTable('{{%package_item_gallery}}');
    }
}
