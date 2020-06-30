<?php namespace AppProducts\Branches\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsBranchesBranches3 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->text('branch_suburb')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->time('branch_suburb')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
