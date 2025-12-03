<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::orderByRaw("
            CASE
                WHEN role = 'admin' THEN 1
                WHEN role = 'dokter' THEN 2
                WHEN role = 'user' THEN 3
                ELSE 4
            END
        ")->select('id', 'name', 'email', 'role', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Created At'
        ];
    }
}
