<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\HomePageSection;

class HomepageSectionThemeTwoUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sections = HomePageSection::orderBy('id', 'ASC')->take(6)->get();
        foreach($sections as $section){
            $section->theme = "default, amazy";
            $section->save();
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
