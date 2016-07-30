<?php

use yii\db\Migration;

class m160729_080843_alter_package_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%package}}', 'header', 'text');
        $this->addColumn('{{%package}}', 'footer', 'text');
    }

    public function down()
    {
        $this->dropColumn('{{%package}}', 'header');
        $this->dropColumn('{{%package}}', 'footer');
    }
}
