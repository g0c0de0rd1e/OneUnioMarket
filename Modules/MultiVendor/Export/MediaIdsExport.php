<?php

namespace Modules\MultiVendor\Export;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MediaIdsExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        $seller_id = getParentSellerId();
        return DB::table('media_managers')->select('id', 'file_name','orginal_name')->where('user_id', $seller_id)->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'file name',
            'orginal name',
        ];
    }
}
