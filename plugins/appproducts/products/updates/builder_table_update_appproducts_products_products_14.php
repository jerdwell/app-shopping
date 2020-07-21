<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts14 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->string('product_note');
            $table->string('product_model');
            $table->string('erso_code');
            $table->string('provider_code');
            $table->string('product_year');
            $table->decimal('public_price', 10, 0);
            $table->decimal('provider_price', 10, 0);
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('shipowner_id');
            $table->string('product_name')->change();
            $table->text('product_description')->nullable(false)->change();
            $table->string('product_slug')->change();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('product_stock');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->dropColumn('product_note');
            $table->dropColumn('product_model');
            $table->dropColumn('erso_code');
            $table->dropColumn('provider_code');
            $table->dropColumn('product_year');
            $table->dropColumn('public_price');
            $table->dropColumn('provider_price');
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
            $table->dropColumn('shipowner_id');
            $table->string('product_name', 150)->change();
            $table->text('product_description')->nullable()->change();
            $table->string('product_slug', 191)->change();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('product_stock')->nullable();
        });
    }
}
