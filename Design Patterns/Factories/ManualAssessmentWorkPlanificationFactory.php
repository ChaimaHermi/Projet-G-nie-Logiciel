<?php

namespace App\Factories;

use App\Models\AssessmentWorkPlanification;
use App\Factories\AssessmentWorkPlanificationFactoryInterface;

class ManualAssessmentWorkPlanificationFactory implements AssessmentWorkPlanificationFactoryInterface
{
    public function create(array $data): AssessmentWorkPlanification
    {
        return AssessmentWorkPlanification::create([
            'assessment_type_id' => $data['assessment_type_id'],
            'offices' => $data['offices'],
            'user_id' => auth()->id(),
            'status' => 'PENDING',
            'date' => $data['date'],
        ]);
    }
}
