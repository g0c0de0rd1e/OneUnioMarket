<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\Benifit;
use App\Traits\ImageStore;

class BenefitRepository {
    use ImageStore;
    protected $benefit;

    public function __construct(Benifit $benefit)
    {
        $this->benefit = $benefit;
    }

    public function getAll()
    {
        return $this->benefit::all();
    }
    public function getAllActive()
    {
        return $this->benefit::where('status',1)->get();
    }

    public function save($data)
    {
        $imageName = ImageStore::saveImage($data['image'],80,60);
        $data['image'] = $imageName;
        $benefit = $this->benefit->fill($data)->save();
        return $benefit;
    }   

    public function update($data, $id)
    {
        $getData = $this->benefit->findOrFail($id);
        if (isset($data['image'])) {
            ImageStore::deleteImage($getData->image);
            $imageName = ImageStore::saveImage($data['image'],80,60);
        } else {
            $imageName =$getData->image;
        }
        return $this->benefit::where('id',$id)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'image' => $imageName
        ]);

    }


    public function delete($id){
        $benefit = $this->benefit->findOrFail($id);
        ImageStore::deleteImage($benefit->image);
        $benefit->delete();
        return $benefit;
    }


    public function edit($id){
        $benefit = $this->benefit->findOrFail($id);
        return $benefit;
    }
}
