<?php

namespace Modules\MultiVendor\Services;
use \Modules\MultiVendor\Repositories\CommisionRepository;

class CommisionService
{
    protected $commisionRepository;
    public function __construct(CommisionRepository $commisionRepository)
    {
        $this->commisionRepository = $commisionRepository;
    }
    public function getAll()
    {
        return $this->commisionRepository->getAll();
    }
    public function findByID($id)
    {
        return $this->commisionRepository->findByID($id);
    }
    public function update($data)
    {
        return $this->commisionRepository->update($data);
    }
}
