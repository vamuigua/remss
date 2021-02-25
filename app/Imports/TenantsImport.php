<?php

namespace App\Imports;

use App\Tenant;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class TenantsImport implements WithHeadingRow, WithBatchInserts, WithChunkReading, OnEachRow
{
    private $duplicates = array();
    private $addedNewTenant;

    // Runs for every row in the uploaded file
    public function onRow(Row $row)
    {
        $row_array = $row->toArray();

        $this->addedNewTenant = false;

        $tenant = Tenant::where('national_id', $row_array['national_id'])->firstOr(function () use ($row_array) {
            $this->addedNewTenant = true;
            Tenant::create([
                'surname' => $row_array['surname'],
                'other_names' => $row_array['other_names'],
                'gender' => $row_array['gender'],
                'national_id' => $row_array['national_id'],
                'phone_no' => $row_array['phone_no'],
                'email' => $row_array['email'],
            ]);
        });

        // Add duplicate tenant to array
        if (!$this->addedNewTenant) {
            array_push($this->duplicates, $tenant);
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
