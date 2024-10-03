<?php

namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\ContactContent;

class ContactContentRepository
{

    protected $contactContent;

    public function __construct(ContactContent $contactContent)
    {
        $this->contactContent = $contactContent;
    }


    public function all(){
        return $this->contactContent::firstOrfail();
        
    }

    public function update($data, $id)
    {
        $contactContent = $this->contactContent::where('id', $id)->first();
        $contactContent->fill($data)->save();
        return $contactContent;
    }

    public function edit($id)
    {
        $contactContent = $this->contactContent->findOrFail($id);
        return $contactContent;
    }
}
