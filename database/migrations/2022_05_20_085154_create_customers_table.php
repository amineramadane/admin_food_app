<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('phone', 60);
            $table->string('email')->nullable();
            $table->integer('language_id');
            $table->integer('status')->nullable();
            $table->integer('number_times_sent')->nullable();
            $table->datetime('send_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'customers_access', 'display_name' => 'Access', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_create', 'display_name' => 'Create', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_show', 'display_name' => 'Show', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_edit', 'display_name' => 'Edit', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_delete', 'display_name' => 'Delete', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_export', 'display_name' => 'Export', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
            ['name' => 'customers_import', 'display_name' => 'Import', 'group_name' => 'customer_charge', 'group_slug' => 'customer_charge', 'guard_name' => 'web'],
        );

        Permission::insert($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
