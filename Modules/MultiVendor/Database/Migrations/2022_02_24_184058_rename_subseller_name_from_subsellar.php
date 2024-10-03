<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Role;

class RenameSubsellerNameFromSubsellar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('roles')){
            $subseller = Role::where('type', 'seller')->orderByDesc('id')->first();
            if($subseller){
                $subseller->name = 'Sub Seller';
                $subseller->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
