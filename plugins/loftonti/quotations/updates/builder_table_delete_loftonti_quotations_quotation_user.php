<?php namespace LoftonTi\Quotations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteLoftontiQuotationsQuotationUser extends Migration
{
    public function up()
    {
        Schema::dropIfExists('loftonti_quotations_quotation_user');
    }
    
    public function down()
    {
        Schema::create('loftonti_quotations_quotation_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('quotation_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
}
