<?php

namespace Modules\PageBuilder\Repositories;
use Modules\FrontendCMS\Entities\DynamicPage;

class PageBuilderRepository
{
    public function all()
    {
        return DynamicPage::where('is_page_builder',1)->get();
    }
    public function create(array $data)
    {
        $data['status'] = 1;
        $data['is_static'] = 0;
        $data['is_page_builder'] = 1;
        $page = new DynamicPage();
        $page->fill($data)->save();
    }
    public function find($id)
    {
        return DynamicPage::findOrFail($id);
    }
    public function designUpdate(array $data,$id)
    {
        return DynamicPage::where('id',$id)->update([
            'description'  => $data['body'],
        ]);
    }
    public function update(array $data,$id)
    {
        $page = DynamicPage::where('id',$id)->first();
        $page->fill($data)->save();
    }
    public function delete($id){
        return DynamicPage::findOrFail($id)->delete();
    }
    public function status($data){
        return DynamicPage::findOrFail($data['id'])->update(['status' => $data['status']]);
    }
}
