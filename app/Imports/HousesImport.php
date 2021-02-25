<?php

namespace App\Imports;

use App\House;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class HousesImport implements WithHeadingRow, WithBatchInserts, WithChunkReading, OnEachRow
{
    private $duplicates = array();
    private $addedNewHouse;

    // Runs for every row in the uploaded file
    public function onRow(Row $row)
    {
        $row_array = $row->toArray();

        $this->addedNewHouse = false;

        $house = House::where('house_no', $row_array['house_no'])->firstOr(function () use ($row_array) {
            $this->addedNewHouse = true;
            House::create([
                'house_no' => $row_array['house_no'],
                'features' => $row_array['features'],
                'rent' => $row_array['rent'],
                'status' => $row_array['status'],
                'water_meter_no' => $row_array['water_meter_no'],
                'electricity_meter_no' => $row_array['electricity_meter_no'],
            ]);
        });

        // Add duplicate house to array
        if (!$this->addedNewHouse) {
            array_push($this->duplicates, $house);
        }
    }

    public function getDuplicates(): array
    {
        return $this->duplicates;
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
