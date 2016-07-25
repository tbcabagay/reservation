<?php

use yii\db\Migration;

class m160725_140531_extend_package_table_for_slugs extends Migration
{
    public function up()
    {
        $this->addColumn('{{%package}}', 'slug', $this->string(250)->notNull());
        $this->addColumn('{{%package_item}}', 'slug', $this->string(250)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%package}}', 'slug');
        $this->dropColumn('{{%package_item}}', 'slug');
    }
}
