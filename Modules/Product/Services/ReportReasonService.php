<?php
namespace Modules\Product\Services;

use Modules\Product\Repositories\ReportReasonRepository;

class ReportReasonService {

    protected $reason;

    public function __construct(ReportReasonRepository $reportReasonRepository){
        $this->reason = $reportReasonRepository;
    }

    public function get(){
        return $this->reason->get();
    }


    public function store($data){
        return $this->reason->store($data);
    }

    public function show($data)
    {
        return $this->reason->show($data);
    }


    public function update($data,$id)
    {
        return $this->reason->update($data,$id);
    }

    public function delete($data)
    {
        return $this->reason->delete($data);
    }

}
