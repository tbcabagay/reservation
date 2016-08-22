<?php

use yii\db\Migration;

class m160822_033256_alter_package_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%package_item}}', 'max_person_per_room', $this->smallInteger()->notNull());
        $this->addColumn('{{%package_item}}', 'penalty_per_excess_person', $this->money()->notNull());
        $this->addColumn('{{%package_item}}', 'penalty_per_excess_hour', $this->money()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%package_item}}', 'max_person_per_room');
        $this->dropColumn('{{%package_item}}', 'penalty_per_excess_person');
        $this->dropColumn('{{%package_item}}', 'penalty_per_excess_hour');
    }
}
