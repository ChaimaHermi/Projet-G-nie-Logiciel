// app/Services/AssessmentWorkPlanificationService.php
namespace App\Services;

use App\Repositories\AssessmentWorkRepository;
use Illuminate\Support\Facades\DB;

class AssessmentWorkPlanificationService
{
    public function __construct(
        private AssessmentWorkRepository $repository
    ) {}

    public function create(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $planification = $this->repository->create($data);
            return [
                'status' => 'success',
                'id' => $planification->id
            ];
        });
    }
}