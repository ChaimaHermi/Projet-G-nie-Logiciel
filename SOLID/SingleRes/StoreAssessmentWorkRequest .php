// app/Http/Requests/StoreAssessmentWorkRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentWorkRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'assessment_type_id' => 'required|exists:assessment_types,id',
            'planned_date' => 'required|date|after:today',
            'offices' => 'required|array',
            'offices.*' => 'exists:offices,id'
        ];
    }
}