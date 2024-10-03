<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\PaymentGateway\Entities\PaymentMethod;
use App\Traits\GenerateSlug;

class PaymentMethodsSlugColumnAdd extends Migration
{
    use GenerateSlug;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('payment_methods')){
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('method');
            });
        }
        if(Schema::hasTable('payment_methods')){
            $methods = PaymentMethod::all();
            foreach($methods as $method){
                $paymentmethod = PaymentMethod::find($method->id);
                $paymentmethod->update([
                 'slug' => $this->productSlug($paymentmethod->method)
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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
