<?php
namespace Modules\Product\Repositories;

use Modules\Product\Entities\ProductReportReason;

class ReportReasonRepository {

    protected $reason;

    public function __construct(ProductReportReason $productReportReason){
        $this->reason = $productReportReason;
    }

    public function get()
    {
        return $this->reason->get();
    }

    public function store($data)
    {
        return $this->reason->create($data);
    }

    public function show($data){
        return $this->reason->where($data)->first();
    }

    public function update($data, $id){
        $reason =  $this->reason->where('id',$id)->first();
        return   $reason->update($data);
    }

    public function delete($data){
        $reason =  $this->reason->where($data)->first();
        return   $reason->delete();
    }

}
