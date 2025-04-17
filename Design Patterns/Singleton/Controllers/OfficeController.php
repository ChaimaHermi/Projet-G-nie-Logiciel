<?php
namespace App\Http\Controllers;

use App\Utils\DatabaseConnectionSingleton;  // Import the Singleton
use App\Concerns\FileUploader;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Services\GeographicalAreaService;
use App\Models\AssessmentType;
use App\Models\Cluster;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfficeController extends Controller
{
    use FileUploader;

    private GeographicalAreaService $geographicalAreaService;

    public function __construct(GeographicalAreaService $geographicalAreaService)
    {
        $this->geographicalAreaService = $geographicalAreaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @method GET
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Example of using the Singleton to get a database connection
            $connection = DatabaseConnectionSingleton::getInstance()->getConnection();

            // Fetch data using the Singleton connection if needed
            $officeTypes = $connection->table('office_types')->select('id', 'name', 'reference')->get();
            $assessmentTypes = $connection->table('assessment_types')->select('id', 'name')->get();
            $sections = $connection->table('sections')->select('id', 'name', 'reference')->get();

            return view('offices.index', [
                'offices' => Office::paginate(10),
                'officeTypes' => $officeTypes,
                'sections' => $sections,
                'assessmentTypes' => $assessmentTypes,
                'clusters' => Cluster::all()
            ]);
        } catch (\Exception $e) {
            Log::critical(_('messages.error_in_index_method_of_offices').$e->getMessage());
            abort(500);
        }
    }

    // Other methods remain unchanged...
}
