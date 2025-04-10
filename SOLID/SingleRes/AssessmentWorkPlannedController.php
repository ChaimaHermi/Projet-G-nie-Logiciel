// app/Http/Controllers/AssessmentWorkPlannedController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessmentWorkRequest;
use App\Services\AssessmentWorkPlanificationService;
use App\Exports\AssessmentWorkPlannedExport;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentWorkPlannedController extends Controller
{
    public function __construct(
        private AssessmentWorkPlanificationService $service
    ) {}

    public function store(StoreAssessmentWorkRequest $request)
    {
        $result = $this->service->create($request->validated());
        return response()->json($result);
    }

    public function export() 
    {
        return Excel::download(new AssessmentWorkPlannedExport(), 'planifications.xlsx');
    }
}