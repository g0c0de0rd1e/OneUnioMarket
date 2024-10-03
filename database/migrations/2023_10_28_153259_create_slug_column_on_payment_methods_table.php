<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlugColumnOnPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('payment_methods','slug')){
            Schema::table('payment_methods',function($table){
                $table->string('slug')->nullable()->after('method');
            });
        }

        if(Schema::hasColumn('payment_methods','slug')){
            $gateways = DB::table('payment_methods')->get();
            foreach($gateways as $gateway){
                    DB::table('payment_methods')->where('id',$gateway->id)->update([
                        'slug' => Str::slug($gateway->method),
                    ]);
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
        if(Schema::hasColumn('payment_methods','slug')){
             Schema::table('payment_methods',function($table){
                $table->dropColumn('slug');
            });
        }
    }
}
