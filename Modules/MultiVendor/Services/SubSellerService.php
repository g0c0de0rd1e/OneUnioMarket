<?php

namespace Modules\MultiVendor\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use \Modules\MultiVendor\Repositories\SubSellerRepository;
use App\Traits\ImageStore;

class SubSellerService
{
    use ImageStore;

    protected $subSellerRepository;

    public function __construct(SubSellerRepository $subSellerRepository)
    {
        $this->subSellerRepository = $subSellerRepository;
    }

    public function getAll()
    {
        return $this->subSellerRepository->getAll();
    }

    public function findUserByID($id)
    {
        return $this->subSellerRepository->findUserByID($id);
    }

    public function create($data)
    {
        if (!empty($data['photo'])) {
            $photo = $this->saveAvatar($data['photo'], 165, 165);
            $data['avatar'] = $photo;
        }
        return $this->subSellerRepository->create($data);
    }

    public function update($data, $id)
    {
        if (!empty($data['photo'])) {
            $user = User::where('id', $id)->first();
            $this->deleteImage($user->avatar);
            $photo = $this->saveAvatar($data['photo'], 165, 165);
            $data['avatar'] = $photo;
        }
        return $this->subSellerRepository->update($data, $id);
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $this->deleteImage($user->avatar);
        return $this->subSellerRepository->delete($id);
    }
}
