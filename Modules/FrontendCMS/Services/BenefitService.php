<?php

namespace Modules\FrontendCMS\Services;

use \Modules\FrontendCMS\Repositories\BenefitRepository;

class BenefitService
{
    protected $benefitRepository;

    public function __construct(BenefitRepository  $benefitRepository)
    {
        $this->benefitRepository = $benefitRepository;
    }

    public function save($data)
    {
        return $this->benefitRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->benefitRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->benefitRepository->getAll();
    }
    public function getAllActive()
    {
        return $this->benefitRepository->getAllActive();
    }

    public function deleteById($id)
    {
        return $this->benefitRepository->delete($id);
    }

    public function editById($id)
    {
        return $this->benefitRepository->edit($id);
    }
}
