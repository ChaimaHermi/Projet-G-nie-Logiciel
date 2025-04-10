<?php

// adapter

namespace App\Adapters;

use App\Models\AssessmentType;
use App\Models\Office;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelRowToPlanificationAdapter implements ExcelRowAdapterInterface
{
    protected array $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function convert(): ?array
    {
        // On suppose que les colonnes sont :
        // 0 => assessment type name, 1 => non utilisé, 2 => user email, 3 => date, 4 => type, 5 => status, 6 => office ref

        $assessmentType = AssessmentType::getAssessmentType($this->row[0]);
        $user = User::where('email', $this->row[2])->first();
        $office = Office::where('reference', $this->row[6])->first();

        if (!$assessmentType || !$user || !$office) {
            return null;
        }

        return [
            'assessment_type_id' => $assessmentType->id,
            'user_id' => $user->id,
            'date' => Date::excelToDateTimeObject($this->row[3]),
            'type' => $this->row[4],
            'status' => $this->row[5],
            'offices' => [$office->id],
        ];
    }
}
