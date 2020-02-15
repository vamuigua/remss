<?php

namespace App\Exports;

use App\House;
use Maatwebsite\Excel\Concerns\FromCollection;

class HousesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return House::all();
    }
}
