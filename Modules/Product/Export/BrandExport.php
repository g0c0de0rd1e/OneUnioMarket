<?php

namespace Modules\Product\Export;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        return DB::table('brands')->select('id', 'name')->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
