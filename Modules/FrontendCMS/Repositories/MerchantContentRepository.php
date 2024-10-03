<?php

namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\MerchantContent;

class MerchantContentRepository
{

    protected $merchantContent;

    public function __construct(MerchantContent $merchantContent)
    {
        $this->merchantContent = $merchantContent;
    }

    public function getAll(){
        return $this->merchantContent->firstOrFail();
    }

    public function update($data, $id)
    {
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = $data['slug'][auth()->user()->lang_code];
        }else{
            $data['slug'] = $data['slug'];
        }
        $merchantContent = $this->merchantContent::where('id', $id)->first();
        $merchantContent->fill($data)->save();
    }

    public function edit($id)
    {
        $merchantContent = $this->merchantContent->findOrFail($id);
        return $merchantContent;
    }
}
