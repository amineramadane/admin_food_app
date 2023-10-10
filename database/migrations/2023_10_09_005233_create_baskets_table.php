<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Helpers\Selects;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', Selects::StatusBasket)->default('onhold');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        $permissions = array(
            ['name' => 'baskets_access', 'display_name' => 'Access', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_create', 'display_name' => 'Create', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_show', 'display_name' => 'Show', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_edit', 'display_name' => 'Edit', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_delete', 'display_name' => 'Delete', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_export', 'display_name' => 'Export', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
            ['name' => 'baskets_import', 'display_name' => 'Import', 'group_name' => 'basket_charge', 'group_slug' => 'basket_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('baskets');
    }
}
