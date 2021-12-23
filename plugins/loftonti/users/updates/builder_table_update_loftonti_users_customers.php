<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersCustomers extends Migration
{
    public function up()
    {
        Schema::rename('loftonti_users_users', 'loftonti_users_customers');
    }
    
    public function down()
    {
        Schema::rename('loftonti_users_customers', 'loftonti_users_users');
    }
}
