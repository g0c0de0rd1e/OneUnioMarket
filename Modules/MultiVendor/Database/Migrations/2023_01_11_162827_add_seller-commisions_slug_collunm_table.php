<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerCommssionType;

class AddSellerCommisionsSlugCollunmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seller_commissions')){
            Schema::table('seller_commissions', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
        }
      $seller_commissions = SellerCommssionType::all();
      foreach ($seller_commissions as  $value) {
          $id = SellerCommssionType::find($value->id);
          if (isModuleActive('FrontendMultiLang')) {
            if ($value->name != '') {
              $name = $value->name;
            }else {
              $name = $value->translateName;
            }
          }else{
            $name = $value->name;
          }
          $id->update([
              'slug' => strtolower(str_replace(' ','-',$name))
            ]);
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_commissions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
