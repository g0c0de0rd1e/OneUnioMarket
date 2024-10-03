<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\RolePermission\Entities\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if(Schema::hasTable("role_permission")){
            $role = Role::where('name','Seller')->first();
            $permissions = [345,346,497,569,570,571,572,573,363,364,365,366,367,368,378,679,680,692,693,681,682,683,384,385,386,387,388,389,390,694,696,695,690,691,532,533,534,535,536];
            if($role)
            {
                foreach($permissions as $permission)
                {
                    $hasPermission =  DB::table('role_permission')->where('permission_id',$permission)->where('role_id',$role->id)->first();
                    if(!$hasPermission){
                        DB::table('role_permission')->insert([
                            "permission_id" => $permission,
                            "role_id" => $role->id,
                            "status" => 1,
                            "created_by" => 1,
                            "updated_by" => 1
                        ]);
                    }
                }
            }
        }

        if(Schema::hasTable("pricings")){
            $pricings = DB::table("pricings")->get();
            $plan = [
                ['monthly_cost' => 10, "yearly_cost" => 10, 'team_size' => 1, 'transaction_fee' => 10, 'is_monthly' => 1, 'status' => 1,'plan_price' => 10, 'expire_in' => 90],
                ['monthly_cost' => 15, "yearly_cost" => 15, 'team_size' => 5, 'transaction_fee' => 10, 'is_monthly' => 1, 'status' => 1,'plan_price' => 15, 'expire_in' => 60],
                ['monthly_cost' => 20, "yearly_cost" => 20, 'team_size' => 10, 'transaction_fee' => 5, 'is_monthly' => 1, 'status' => 1,'plan_price' => 20, 'expire_in' => 365],
            ];
            foreach($pricings as $key => $pricing){
                DB::table('pricings')->where('id',$pricing->id)->update($plan[$key]);
            }
        }


        if(Schema::hasTable('delivery_processes')){
            $processes = DB::table("delivery_processes")->get();
            foreach($processes  as $processe)
            {
                DB::table('delivery_processes')->where('id',$processe->id)->update([
                    "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,"
                ]);
            }
        }


        if(Schema::hasTable('seller_commissions')){
            $commissions = DB::table("seller_commissions")->get();
            foreach($commissions  as $commission)
            {
                DB::table('seller_commissions')->where('id',$commission->id)->update([
                    "slug" => Str::slug($commission->name),
                ]);
            }
        }

        if(Schema::hasTable("backendmenus")){
            $backend_menu = DB::table('backendmenus')->where('name','setup.algolia_search_setup')->first();
            if($backend_menu)
            {
                DB::table('backendmenu_users')->where('backendmenu_id',$backend_menu->id)->delete();
                DB::table('backendmenus')->where('name','setup.algolia_search_setup')->delete();
            }
        }





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
