<?php

namespace App\Exports;

use App\Tenant;
use Maatwebsite\Excel\Concerns\FromCollection;

class TenantsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tenant::all();
    }
}
