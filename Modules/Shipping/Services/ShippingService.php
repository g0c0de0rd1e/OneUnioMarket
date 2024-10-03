<?php
namespace Modules\Shipping\Services;
use \Modules\Shipping\Repositories\ShippingRepository;

class ShippingService
{
    protected $shippingRepository;
    public function __construct(ShippingRepository  $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }
    public function getAll()
    {
        return $this->shippingRepository->getAll();
    }
    public function getRequestedSellerOwnShippingMethod()
    {
        return $this->shippingRepository->getRequestedSellerOwnShippingMethod();
    }
    public function getActiveAll()
    {
        return $this->shippingRepository->getActiveAll();
    }

    public function store($data)
    {
        return $this->shippingRepository->store($data);
    }

    public function findById($id)
    {
        return $this->shippingRepository->find($id);
    }

    public function update($data, $id)
    {
        return $this->shippingRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->shippingRepository->delete($id);
    }

    public function updateStatus($data)
    {
        return $this->shippingRepository->updateStatus($data);
    }

    public function updateApproveStatus($data)
    {
        return $this->shippingRepository->updateApproveStatus($data);
    }

    public function getActiveAllForAPI(){
        return $this->shippingRepository->getActiveAllForAPI();
    }
}
