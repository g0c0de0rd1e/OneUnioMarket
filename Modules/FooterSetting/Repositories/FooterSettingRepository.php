<?php
namespace Modules\FooterSetting\Repositories;
use App\Traits\ImageStore;
use Modules\FooterSetting\Entities\FooterContent;
use Modules\GeneralSetting\Entities\GeneralSetting;

class FooterSettingRepository {
    use ImageStore;
    protected $footer;
    public function __construct(GeneralSetting $footer)
    {
        $this->footer = $footer;
    }
    public function getAll(){
        return $this->footer::firstOrFail();
    }
    public function getFooterContent(){
        return FooterContent::first();
    }
    public function update($data, $id)
    {
        $item = $this->footer::find($id);
        $data['footer_copy_right'] = isset($data['copy_right'])?$data['copy_right']:$item->footer_copy_right;
        $data['footer_about_title'] = isset($data['about_title'])?$data['about_title']:$item->footer_about_title;
        $data['footer_about_description'] = isset($data['about_description'])?$data['about_description']:$item->footer_about_description;
        $data['footer_section_one_title'] = isset($data['company_title'])?$data['company_title']:$item->footer_section_one_title;
        $data['footer_section_two_title'] = isset($data['account_title'])?$data['account_title']:$item->footer_section_two_title;
        $data['footer_section_three_title'] = isset($data['service_title'])?$data['service_title']:$item->footer_section_three_title;
        $item->fill($data)->save();
    }
    public function updateAppLink($data){
        $content = FooterContent::first();
        if($content){
            $image_link = $content->payment_image;
            if(isset($data['payment_image'])){
                $this->deleteImage($image_link);
                $image_link = $this->saveImage($data['payment_image']);
            }
            $data['payment_image'] = $image_link;
            $data['show_play_store'] = isset($data['play_store_show'])?1:0;
            $data['show_app_store'] = isset($data['app_store_show'])?1:0;
            $data['show_payment_image'] = isset($data['show_payment_image'])?1:0;
            $content->fill($data)->save();
            return true;
        }
        return false;
    }
    public function edit($id){
        $footer = $this->footer->findOrFail($id);
        return $footer;
    }
}
