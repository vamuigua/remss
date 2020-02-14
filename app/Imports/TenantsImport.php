<?php

namespace App\Imports;

use App\Tenant;
use Maatwebsite\Excel\Concerns\ToModel;

class TenantsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tenant([
            'surname' => $row[0],
            'other_names' => $row[1], 
            'gender' => $row[2],
            'national_id' => $row[3],
            'phone_no' => $row[4],
            'email' => $row[5],
        ]);
    }
}
