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
        Schema::create('botmessages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('welcome_message');
            $table->text('excuse_message');
            $table->text('cancel_message');
            $table->integer('bot_id'); 
            $table->integer('language_id');
            $table->timestamps(); 
            $table->softDeletes(); 
        });
        $permissions = array(
            ['name' => 'botmessages_access', 'display_name' => 'Access', 'group_name' => 'botmessage_charge', 'group_slug' => 'botmessage_charge', 'guard_name' => 'web'],
            ['name' => 'botmessages_create', 'display_name' => 'Create', 'group_name' => 'botmessage_charge', 'group_slug' => 'botmessage_charge', 'guard_name' => 'web'],
            ['name' => 'botmessages_show', 'display_name' => 'Show', 'group_name' => 'botmessage_charge', 'group_slug' => 'botmessage_charge', 'guard_name' => 'web'],
            ['name' => 'botmessages_edit', 'display_name' => 'Edit', 'group_name' => 'botmessage_charge', 'group_slug' => 'botmessage_charge', 'guard_name' => 'web'],
            ['name' => 'botmessages_delete', 'display_name' => 'Delete', 'group_name' => 'botmessage_charge', 'group_slug' => 'botmessage_charge', 'guard_name' => 'web'],
        );

        Permission::insert($permissions);

        collect($permissions)->map(function($item) {
            Role::find(1)->givePermissionTo($item['name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('botmessages');
    }
};
