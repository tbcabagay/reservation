<?php

use yii\db\Migration;

class m160816_031737_alter_package_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%package_item}}', 'photo', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%package_item}}', 'photo');
    }
}
