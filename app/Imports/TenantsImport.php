<?php

namespace App\Imports;

use App\Tenant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TenantsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tenant([
            'surname' => $row['surname'],
            'other_names' => $row['other_names'], 
            'gender' => $row['gender'],
            'national_id' => $row['national_id'],
            'phone_no' => $row['phone_no'],
            'email' => $row['email'],
        ]);
    }
     public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
