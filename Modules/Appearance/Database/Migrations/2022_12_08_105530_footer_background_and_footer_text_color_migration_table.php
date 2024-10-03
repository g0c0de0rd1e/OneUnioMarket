<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\ThemeColor;

class FooterBackgroundAndFooterTextColorMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('theme_colors', 'footer_color')) {
            DB::statement("ALTER TABLE `theme_colors` CHANGE `footer_color` `footer_background_color` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
        }
        if(Schema::hasTable('theme_colors')){
            Schema::table('theme_colors', function (Blueprint $table) {
                $table->string('footer_text_color')->nullable()->after('footer_background_color');
            });
        }
       $themecolor = ThemeColor::find(1);
       $themecolor->update([
        'footer_text_color'=> '#fff'
       ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('theme_colors', function (Blueprint $table) {
            $table->dropColumn('footer_text_color');
        });
        Schema::table('theme_colors', function (Blueprint $table) {
            $table->dropColumn('footer_background_color');
        });
    }
}
