// app/Repositories/AssessmentWorkRepository.php
namespace App\Repositories;

use App\Models\AssessmentWorkPlanification;

class AssessmentWorkRepository
{
    public function create(array $data): AssessmentWorkPlanification
    {
        return AssessmentWorkPlanification::create($data);
    }

    public function delete(int $id): bool
    {
        return AssessmentWorkPlanification::destroy($id);
    }
}