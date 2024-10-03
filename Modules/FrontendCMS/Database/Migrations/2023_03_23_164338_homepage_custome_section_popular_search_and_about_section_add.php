<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\HomePageSection;

class HomepageCustomeSectionPopularSearchAndAboutSectionAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['title' => 'Popular Searches','section_name' => 'popular_search','section_for' => 5, 'column_size' => 'col-lg-12','type' => 3, 'status' => 1,'theme' => 'amazy','created_at' => now(),'updated_at' => now()],
            ['title' => 'About Section','section_name' => 'about_section','section_for' => 5, 'column_size' => 'col-lg-12','type' => 3, 'status' => 1,'theme' => 'amazy','created_at' => now(),'updated_at' => now()]
            
        ];
         HomePageSection::insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sections = HomePageSection::whereIn('section_name', ['popular_search','about_section'])->pluck('id')->toArray();
        HomePageSection::destroy($sections);
    }
}
