// app/Exports/AssessmentWorkPlannedExport.php
namespace App\Exports;

use App\Models\AssessmentWorkPlanification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssessmentWorkPlannedExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'Date Planifiée',
            'Type d\'Évaluation'
        ];
    }

    public function collection()
    {
        return AssessmentWorkPlanification::query()
            ->select('id', 'planned_date', 'assessment_type_id')
            ->get();
    }
}