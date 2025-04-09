<?php

namespace App\Factories;

use App\Models\AssessmentWorkPlanification;
use App\Factories\AssessmentWorkPlanificationFactoryInterface;
use Carbon\Carbon;

class ExcelAssessmentWorkPlanificationFactory implements AssessmentWorkPlanificationFactoryInterface
{
    public function create(array $data): AssessmentWorkPlanification
    {
        return AssessmentWorkPlanification::create([
            'assessment_type_id' => $data['assessment_type_id'],
            'offices' => json_decode($data['offices']),
            'user_id' => $data['user_id'],
            'status' => 'IMPORTED',
            'date' => Carbon::parse($data['date']),
            'notes' => $data['notes'] ?? '',
            'type' => $data['type'] ?? 'import',
        ]);
    }
}
