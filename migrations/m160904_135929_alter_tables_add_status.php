<?php

use yii\db\Migration;

class m160904_135929_alter_tables_add_status extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%package}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%package_item}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%menu_category}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%menu_item}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%menu_package}}', 'status', $this->smallInteger()->notNull());
        $this->addColumn('{{%spa}}', 'status', $this->smallInteger()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%news}}', 'status');
        $this->dropColumn('{{%package}}', 'status');
        $this->dropColumn('{{%package_item}}', 'status');
        $this->dropColumn('{{%menu_category}}', 'status');
        $this->dropColumn('{{%menu_item}}', 'status');
        $this->dropColumn('{{%menu_package}}', 'status');
        $this->dropColumn('{{%spa}}', 'status');
    }
}
