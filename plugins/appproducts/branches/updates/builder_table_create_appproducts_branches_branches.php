<?php namespace AppProducts\Branches\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsBranchesBranches extends Migration
{
    public function up()
    {
        Schema::create('appproducts_branches_branches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('branch_name');
            $table->string('branch_address');
            $table->string('branch_zip_code');
            $table->string('branch_city');
            $table->string('branch_country');
            $table->text('branch_contact');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_branches_branches');
    }
}
