<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\FrontendCMS\Entities\HomePageCustomSection;

class HomepageCustomeSectionCategoryAddPartTwoIncrementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $update =  HomePageSection::find(7);
        $update->update([
            'section_name' => 'filter_category_1',
        ]);
        $sql = [
            ['title' => 'Electronics','section_name' => 'filter_category_2','section_for' => 4, 'column_size' => 'col-lg-12','type' => 1, 'status' => 1,'theme' => 'amazy','created_at' => now(),'updated_at' => now()],
            ['title' => 'Fashion','section_name' => 'filter_category_3','section_for' => 4, 'column_size' => 'col-lg-12','type' => 1, 'status' => 1,'theme' => 'amazy','created_at' => now(),'updated_at' => now()]
            
        ];
         HomePageSection::insert($sql);
         $sections = HomePageSection::whereIn('section_name',['filter_category_2','filter_category_3'])->get();
        foreach($sections as $section){
            HomePageCustomSection::create([
                'section_id' => $section->id
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
        $sections = HomePageSection::whereIn('section_name', ['filter_category_1','filter_category_2','filter_category_3'])->pluck('id')->toArray();
        HomePageSection::destroy($sections);
        $custome_sections = HomePageSection::whereIn('section_name',['filter_category_2','filter_category_3'])->get();
        foreach ($custome_sections as $section) {
            HomePageCustomSection::destroy('section_id',$section->id);
        }
    }
}
