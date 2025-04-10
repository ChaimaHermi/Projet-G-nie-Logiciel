<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentWorkPlanned extends Model
{
    /**
     * Valide la cohérence des dates de planification
     * 
     * @return bool
     */
    public function validateDates(): bool
    {
        return $this->planned_end_date >= $this->planned_start_date;
    }
}
