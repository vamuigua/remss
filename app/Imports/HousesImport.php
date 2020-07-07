<?php

namespace App\Imports;

use App\House;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HousesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new House([
            'house_no' => $row['house_no'],
            'features' => $row['features'], 
            'rent' => $row['rent'],
            'status' => $row['status'],
            'water_meter_no' => $row['water_meter_no'],
            'electricity_meter_no' => $row['electricity_meter_no'],
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
