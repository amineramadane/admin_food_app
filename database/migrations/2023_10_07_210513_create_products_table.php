<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // "active":"1",
            // "category":"pizza",
            // "category_id":"375",
            // "currency":"Rs.",
            // "description":"paneer pizza",
            // "discount":"20",
            // "homepage":"YES",
            // "id":"1070",
            // "image":"assets/images/ProductImage/product/20220813070827000000.png",
            // "name":"Pizza",
            // "prepareTime":"31",
            // "price":"200"
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->text('description')->nullable();
            $table->float('ht_price');
            $table->integer('vat_rate')->default(0);
            $table->integer('price')->nullable();
            $table->integer('prepareTime');
            $table->integer('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'products_access', 'display_name' => 'Access', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_create', 'display_name' => 'Create', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_show', 'display_name' => 'Show', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_edit', 'display_name' => 'Edit', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_delete', 'display_name' => 'Delete', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_export', 'display_name' => 'Export', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
            ['name' => 'products_import', 'display_name' => 'Import', 'group_name' => 'product_charge', 'group_slug' => 'product_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('products');
    }
}
