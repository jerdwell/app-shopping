<?php namespace LoftonTi\Quotations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiQuotationsQuotationUser extends Migration
{
    public function up()
    {
        Schema::create('loftonti_quotations_quotation_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('quotation_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_quotations_quotation_user');
    }
}
