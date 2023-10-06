<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use App\Models\Role;

class CreateOfMotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tds');

        Schema::create('of_motifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('motif');

            $table->softDeletes();
            $table->timestamps();
        });
        
        $permissions = array(
            ['name' => 'of_motifs_access', 'display_name' => 'Access', 'group_name' => 'of_motifs_charge', 'group_slug' => 'of_motifs_charge', 'guard_name' => 'web'],
            ['name' => 'of_motifs_create', 'display_name' => 'Create', 'group_name' => 'of_motifs_charge', 'group_slug' => 'of_motifs_charge', 'guard_name' => 'web'],
            ['name' => 'of_motifs_show', 'display_name' => 'Show', 'group_name' => 'of_motifs_charge', 'group_slug' => 'of_motifs_charge', 'guard_name' => 'web'],
            ['name' => 'of_motifs_edit', 'display_name' => 'Edit', 'group_name' => 'of_motifs_charge', 'group_slug' => 'of_motifs_charge', 'guard_name' => 'web'],
            ['name' => 'of_motifs_delete', 'display_name' => 'Delete', 'group_name' => 'of_motifs_charge', 'group_slug' => 'of_motifs_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('of_motifs');
    }
}
