<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\DynamicPage;

class DynamicPageRepository {

    protected $dynamicPage;

    public function __construct(DynamicPage $dynamicPage){
        $this->dynamicPage = $dynamicPage;
    }


    public function getAll()
    {
        return $this->dynamicPage::where('is_static',0)->where('is_page_builder',0)->get();
    }
    public function getActiveAll()
    {
       $data = $this->dynamicPage::where('status',1)->get();

        if(!isModuleActive('Affiliate')){
            $data =  $data->filter(function($item) {
                if($item->module != 'Affiliate'){
                    return $item->id;
                }
            });
        }

        if(!isModuleActive('Lead')){
            $data =  $data->filter(function($item) {
                if($item->module != 'Lead'){
                    return $item->id;
                }
            });
        }
        return $data;
    }

    public function save($data)
    {
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = $data['slug'][auth()->user()->lang_code];
        }else{
            $data['slug'] = $data['slug'];
        }
        $this->dynamicPage->fill($data)->save();
    }

    public function update($data, $id)
    {
        $dynamicPageUpdate = $this->dynamicPage::where('id',$id)->first();
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = $data['slug'][auth()->user()->lang_code];
        }else{
            $data['slug'] = $data['slug'];
        }
        $dynamicPageUpdate->fill($data)->save();
    }

    public function delete($id){
        $dynamicPage = $this->dynamicPage->findOrFail($id);

        if(count($dynamicPage->MenuElements) > 0 || count($dynamicPage->footerWidgets) > 0){
            return "not_possible";
        }
        $dynamicPage->delete();

        return 'possible';
    }

    public function show($id){
        $dynamicPage = $this->dynamicPage->findOrFail($id);
        return $dynamicPage;
    }

    public function edit($id){
        $dynamicPage = $this->dynamicPage->findOrFail($id);
        return $dynamicPage;
    }
    public function statusUpdate($data, $id){
        return $this->dynamicPage::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }
}
