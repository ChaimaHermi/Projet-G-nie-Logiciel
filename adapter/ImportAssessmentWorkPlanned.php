<?php

namespace App\Imports;

use App\Adapters\ExcelRowToPlanificationAdapter;
use App\Models\AssessmentWorkPlanification;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportAssessmentWorkPlanned implements ToCollection, WithStartRow, WithChunkReading, ShouldQueue
{
    public function __construct() {}

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                if (empty($row[0])) continue;

                $adapter = new ExcelRowToPlanificationAdapter($row->toArray());
                $data = $adapter->convert();

                if ($data !== null) {
                    AssessmentWorkPlanification::create($data);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error('Erreur lors de l’importation : ' . $e->getMessage());
            DB::rollBack();
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 20;
    }
}
