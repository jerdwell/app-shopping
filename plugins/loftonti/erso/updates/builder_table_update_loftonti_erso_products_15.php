<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts15 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->decimal('customer_price', 10, 2)->nullable();
            $table->string('product_description', 191)->default(null)->change();
            $table->string('product_note', 191)->default(null)->change();
            $table->integer('erso_code_id')->default(null)->change();
            $table->decimal('public_price', 10, 2)->default(null)->change();
            $table->string('product_cover', 191)->default(null)->change();
            $table->integer('brand_id')->default(null)->change();
            $table->integer('category_id')->default(null)->change();
            $table->integer('shipowner_id')->default(null)->change();
            $table->integer('enterprise_id')->default(null)->change();
            $table->integer('model_id')->default(null)->change();
            $table->dropColumn('provider_price');
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->dropColumn('customer_price');
            $table->string('product_description', 191)->default('NULL')->change();
            $table->string('product_note', 191)->default('NULL')->change();
            $table->integer('erso_code_id')->default(NULL)->change();
            $table->decimal('public_price', 10, 2)->default(NULL)->change();
            $table->string('product_cover', 191)->default('NULL')->change();
            $table->integer('brand_id')->default(NULL)->change();
            $table->integer('category_id')->default(NULL)->change();
            $table->integer('shipowner_id')->default(NULL)->change();
            $table->integer('enterprise_id')->default(NULL)->change();
            $table->integer('model_id')->default(NULL)->change();
            $table->decimal('provider_price', 10, 2)->nullable()->default(NULL);
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
