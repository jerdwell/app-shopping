<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProdTag extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_prod_tag', function($table)
        {
            $table->dropPrimary(['id_product','id_tag']);
            $table->integer('product_id');
            $table->integer('tag_id');
            $table->dropColumn('id_product');
            $table->dropColumn('id_tag');
            $table->primary(['product_id','tag_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_prod_tag', function($table)
        {
            $table->dropPrimary(['product_id','tag_id']);
            $table->dropColumn('product_id');
            $table->dropColumn('tag_id');
            $table->integer('id_product');
            $table->integer('id_tag');
            $table->primary(['id_product','id_tag']);
        });
    }
}
