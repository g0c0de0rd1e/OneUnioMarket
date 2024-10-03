<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;

class AddSubscriptionTypeFieldToSellerPaymentInfo extends Migration
{
    
    public function up()
    {
        if(Schema::hasTable('subscription_payment_info')){
            Schema::table('subscription_payment_info', function (Blueprint $table) {
                $table->unsignedBigInteger('seller_id')->after('id');
                $table->string('subscription_type')->default('monthly')->after('txn_id');
                $table->string('commission_type')->nullable()->after('subscription_type');
            });
            $payments = SubsciptionPaymentInfo::with('transaction.user.sellerAccount')->where('transaction_id', '!=', null)->get();
            foreach($payments as $payment){
                $payment->update([
                    'seller_id' => @$payment->transaction->created_by,
                    'subscription_type' => @$payment->transaction->user->sellerAccount->subscription_type,
                    'commission_type' => @$payment->transaction->morphable->pricing->name
                ]);
            }
        }

        if(Schema::hasTable('permissions')){
            $sql = [
                ['id' => 711, 'module_id' => 29, 'parent_id' => 515, 'module' => 'MultiVendor', 'name' => 'Pay subscription fee', 'route' => 'seller.subscription_payment_select', 'type' => 2 ],
                ['id' => 712, 'module_id' => 29, 'parent_id' => 515, 'module' => 'MultiVendor', 'name' => 'Change subscription type', 'route' => 'seller.change_subscription_type', 'type' => 2 ],
                ['id' => 713, 'module_id' => 29, 'parent_id' => 515, 'module' => 'MultiVendor', 'name' => 'Payment List', 'route' => 'seller.my_subscription_payment_list', 'type' => 2 ],
            ];
            DB::table('permissions')->insert($sql);
        }
        if(Schema::hasTable('role_permission')){
            $seller = Role::where('name', 'Seller')->first();
            $sub_seller = Role::where('name', 'Seller')->first();
            $role_permissions = [
                ['permission_id' => 711,'role_id' => $seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 712,'role_id' => $seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 713,'role_id' => $seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 711,'role_id' => $sub_seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 712,'role_id' => $sub_seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 713,'role_id' => $sub_seller->id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')]
            ];
            DB::table('role_permission')->insert($role_permissions);
        }
        if(Schema::hasTable('seller_accounts')){
            $seller_accounts = SellerAccount::where('subscription_type','!=','monthly')->where('subscription_type','!=','yearly')->where('subscription_type','!=',null)->where('seller_commission_id',3)->get();
            foreach($seller_accounts as $account){
                $account->update([
                    'subscription_type' => 'monthly'
                ]);
            }
        }
    }

    public function down()
    {
        Schema::table('subscription_payment_info', function (Blueprint $table) {
            $table->dropColumn('seller_id');
            $table->dropColumn('subscription_type');
            $table->dropColumn('commission_type');
        });
        if(Schema::hasTable('permissions')){
            Permission::destroy([711,712,713]);
        }

    }
}
