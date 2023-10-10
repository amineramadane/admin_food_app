<?php

use App\Helpers\Selects;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('basket_id');
            $table->enum('status', Selects::StatusOrder)->default('onhold');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('basket_id')->references('id')->on('baskets');
        });

        $permissions = array(
            ['name' => 'orders_access', 'display_name' => 'Access', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_create', 'display_name' => 'Create', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_show', 'display_name' => 'Show', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_edit', 'display_name' => 'Edit', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_delete', 'display_name' => 'Delete', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_export', 'display_name' => 'Export', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
            ['name' => 'orders_import', 'display_name' => 'Import', 'group_name' => 'order_charge', 'group_slug' => 'order_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('orders');
    }
}
