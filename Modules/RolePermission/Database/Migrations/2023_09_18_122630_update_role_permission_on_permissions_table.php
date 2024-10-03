<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateRolePermissionOnPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('id',646)->update([
            "name" => "Edit"
        ]);
        DB::table('permissions')->where('id',734)->where('parent_id',82)->update([
            "name" => "Bulk Customer Upload"
        ]);
        DB::table('permissions')->where('id',448)->where('route','attendance_report.index')->update(['id' => 755]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
