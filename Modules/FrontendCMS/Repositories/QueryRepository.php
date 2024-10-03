<?php
namespace Modules\FrontendCMS\Repositories;
use Modules\FrontendCMS\Entities\InQuery;

class QueryRepository {
    public function getAll()
    {
        return InQuery::all();
    }
    public function getAllActive()
    {
        return InQuery::where('status',1)->get();
    }
    public function save($data)
    {   
        $inquery = new InQuery();
        $inquery->fill($data)->save();
        return $inquery;
    }
    public function update($data, $id)
    {   
        $inquery = InQuery::find($id);
        $inquery->fill($data)->save();
        return $inquery;
    }
    public function delete($id){
        $inquery = InQuery::find($id);
        $inquery->delete();
        return $inquery;
    }
    public function show($id){
        $query = InQuery::find($id);;
        return $query;
    }
    public function edit($id){
        $query = InQuery::find($id);;
        return $query;
    }
    public function statusUpdate($data, $id){
        return InQuery::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }
}
