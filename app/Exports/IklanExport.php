<?php

namespace App\Exports;

use App\Models\Iklan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IklanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Iklan::select('id', 'nama', 'gambar', 'keterangan', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Iklan',
            'Gambar',
            'Keterangan',
            'Created At'
        ];
    }
}
