<?php

namespace App\Http\Controllers;

use App\Concerns\FileUploader;
use App\Exports\AssessmentWorkPlannedExport;
use App\Http\Requests\StoreAssessmentWorkRequest;
use App\Imports\ImportAssessmentWorkPlanned;
use App\Models\AssessmentType;
use App\Models\AssessmentWorkPlanification;
use App\Models\Building;
use App\Models\Cluster;
use App\Models\Facility;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Section;
use App\Models\User;
use App\Traits\OfficeQueryTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentWorkPlannedController extends Controller
 {
    use OfficeQueryTrait , FileUploader ;

    /**
     * @return [type]
     * @author saifeddin ghouma <saifgouma@gmail.com>
     */
    public function index()
    {
        try{
            return view('assessment-work-planned.index',[
                'officeTypes' => OfficeType::select('id', 'name', 'reference')->get(),
                'assessmentTypes' => AssessmentType::select('id', 'name')->get(),
                'offices' => Office::select('id', 'name', 'reference')->get(),
                'sections' => Section::select('id', 'name', 'reference')->get(),
                'buildings' => Building::select('id', 'name', 'reference')->get(),
                'facilities' => Facility::select('id', 'name', 'reference')->get(),
                'clusters' => Cluster::select('id', 'name', 'reference')->get(),
                'users'=> User::get(),
            ]);
        }catch(Exception $e){
            Log::critical("Error failed  index assessment work : " . $e->getMessage());
            abort(500);

        }
    }
    /**
     * @return [type]
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     */
    public function create()
    {
        try{

        return view('assessment-work-planned.create',[
            'assessment_types'=>AssessmentType::get(['id','name']) ,
            'users'=> User::get(),
            'office_types'=>OfficeType::get(['id','name'])
        ]);

        }catch(Exception $e){
            Log::critical("Error failed  create assessment work : " . $e->getMessage());
            abort(500);
         }
    }
    /**
     * @param mixed $table
     * @param mixed $office_ids=[]
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    private function getIds($table , $office_ids=[])
    {
        try{
         return match($table){
            'clusters'=> $this->getClustersByOffices($office_ids),
            'facilities'=>$this->getFacilitiesByOffices($office_ids),
            'buildings'=>$this->getBuilldingsByOffices($office_ids),
            'sections'=> $this->getSectionsByOffices($office_ids),
            'office_types'=> $this->getOfficeTypesByOffices($office_ids),

            };
        }catch(Exception $e){
            Log::critical("Error failed  getIds assessment work : " . $e->getMessage());
            abort(500);
        }

    }

    /**
     * @param AssessmentWorkPlanification $assessment_work_planification
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function edit(AssessmentWorkPlanification $assessment_work_planification)
    {
         try{

            $office_ids = $assessment_work_planification->offices ;
             return view('assessment-work-planned.edit',[
                'assessment_types'=>AssessmentType::get(['id','name']) ,
                'users'=> User::get(),
                'assessment_work_planification'=>$assessment_work_planification,
                'clusters'=>Cluster::get(['id','name']),
                'cluster_ids'=> $this->getIds('clusters' ,$office_ids),
                'facilites'=>Facility::get(['id','name']),
                'facility_ids'=> $this->getIds('facilities' ,$office_ids),
                'buildings'=>Building::get(['id','name']),
                'building_ids'=>  $this->getIds('buildings' ,$office_ids),
                'sections'=>Section::get(['id','name']),
                'section_ids'=>  $this->getIds('sections' ,$office_ids),
                'office_types'=>OfficeType::get(['id','name']),
                'office_type_ids'=> $this->getIds('office_types' ,$office_ids),
                'offices'=>Office::get(['id','name']),
            ]);
        }catch(Exception $e){
            Log::critical("Error failed  edit assessment work : " . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param Request $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function getData(Request $request)
    {
        try{
            if(!empty($request->fk_id)){
                $ids  = !empty($request->fk_id) ? $request->ids : [] ;
                $office_types =  !empty($request->office_types) ? $request->office_types : [] ;
                $data = DB::table($request->table)
                              ->when((!empty($office_types) && ($request->fk_id =='section_id')),
                                    function($query ) use($office_types){
                                       $query->whereIn('office_type_id',$office_types);
                                    }
                                 )
                              ->whereIn($request->fk_id,$ids)
                              ->get(['id','name as text']);

            }else{

                $data = DB::table($request->table)->get(['id','name as text']);

            }
            return response()->json([
                'status'=>1 ,
                'table'=>$request->table ,
                 'data'=> $data
            ]);
        }catch(Exception $e){
            Log::critical("Error failed  getData assessment work : " . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param mixed $number
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    private function  assessmentWorkAfterInsert($number)
    {
        try{
            return AssessmentWorkPlanification::orderBy('id','desc')->take($number)->get() ;
        }catch(Exception $e){
            Log::critical("Error failed  assessment work after insert assessment work : " . $e->getMessage());
            abort(500);
        }
    }
    /**
     * @param Request $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function store(StoreAssessmentWorkRequest $request)
    {
        DB::beginTransaction();
       try{
            $function = match($request->model){
                'clusters'=> $this->getOfficeByCluster($request->ids , $request->office_types),
                'facilities'=> $this->getOfficeByFacilite($request->ids , $request->office_types),
                'buildings'=> $this->getOfficeByBuilding($request->ids , $request->office_types),
                'sections'=> $this->getOfficeBySection($request->ids , $request->office_types),
                'offices'=> $this->getOfficeByIds($request->ids, $request->office_types),
            };

            if(empty($function)){
                return response()->json([
                    'data'=>[],
                    'status'=>0 ,
                    'message'=>__('assessment-work.messages.office_not_found')
                ]);
            }
            /**** when user stoped in cluster ****/
            if($request->model=='clusters'){
                $facilites = DB::table('facilities')
                                ->whereIn('cluster_id',$request->ids)
                                ->pluck('id')
                                ->toArray();
                $values =    $this->setValues($facilites , $request);
                $data = view('assessment-work-planned.create-facilite-users',[
                             'values'=> $values ,
                             'users'=>User::get()]
                            )->render();
                return response()->json([
                    'data'=>$data,
                    'status'=>1
                ]);
            }
             $data = $request->all();
            $data['offices'] = $function;
            AssessmentWorkPlanification::create($data);
            DB::commit();
             return response()->json([
                'status'=>2 ,
                'route'=>route('assessment.work.planned.index'),
                'message'=>__('admin.messages.success_add')
            ]);

        }catch(Exception $e){
            dd($e->getMessage());
              Log::critical("Error failed  store assessment work : " . $e->getMessage());
                abort(500);
        }

    }
    /**
     * @param mixed $facilites
     * @param mixed $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    private function setValues($facilites ,$request)
    {
        try{
            $assessment_work_array = [];
            foreach($facilites as $facility){
                 $array= [];
                 $array['referance']= $this->generateRef($request->assessment_type_id);
                $array['date'] = $request->date ;
                $array['type'] =  $request->type ;
                $array['status'] = $request->status ;
                $array['notes'] = $request->notes ;
                $array['offices'] = json_encode(array_values($this->getOfficeByFacilite([$facility]))) ;
                $array['assessment_type_id'] =  $request->assessment_type_id;
                $array['facility']= $this->getFacilityNameByOffices(json_decode($array['offices'],true)) ;
                $array['user_id'] = $request->user ;
                if(!empty(json_decode($array['offices'],true))){
                    $assessment_work_array[] =  $array ;
                }
            }

            return $assessment_work_array ;

        }catch(Exception $e){
            Log::critical("Error failed  setValues assessment work : " . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param mixed $id
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    private function generateRef($id)
    {
        try{
            $count = !empty(AssessmentWorkPlanification::orderBy('id','desc')->first())?AssessmentWorkPlanification::orderBy('id','desc')->first()->id + 1 : 0 ;
            return sprintf('Assessment-work-'.str_replace(' ','_',AssessmentType::find($id)->getTranslation('name','en')).'-%s-%04u',
                    now()->format('d-m-Y'),
                    $count+1
                );
        }catch(Exception $e){
            Log::critical("Error failed  generateRef assessment work : " . $e->getMessage());
            abort(500);
        }

    }
    /**
     * @param StoreAssessmentWorkRequest $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function update(StoreAssessmentWorkRequest $request , AssessmentWorkPlanification $assessmentWork)
    {
        try{
            $data = $request->all();
            $data['offices'] = $request->offices ;
            $assessmentWork->update($data);
            $this->success(__('admin.messages.success_edit'));
            return redirect()->route('assessment.work.planned.index');

        }catch(Exception $e){
            Log::critical("Error failed  update assessment work : " . $e->getMessage());
            abort(500);
        }

    }
    /**
     * @param Request $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function destroy(Request $request)
    {
        try{
            $assessmentWork = AssessmentWorkPlanification::find($request->id);
            if(!empty($assessmentWork)){
                $assessmentWork->delete();
                return response()->json([
                    'status'=> 1 ,
                    'message'=> __('admin.messages.success_delete',array('model'=>__('assessment-work.assessment-work')))
                ]) ;
            }
            return response()->json([
                'status'=> 0 ,
                'message'=> __('admin.messages.error_delete_not_found',array('model'=>__('assessment-work.assessment-work')))
            ]) ;
        }catch(Exception $e){
                 Log::critical("Error failed  destroy assessment work : " . $e->getMessage());
                abort(500);
            }
    }

    /**
     * @param Request $request
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function storeAssessmentWorkByFacility(Request $request)
    {
        DB::beginTransaction();
        try{

            $assessment_works = $request->assessment_works ;
            DB::table('assessment_work_planifications')->insert($assessment_works);
            DB::commit();
            return response()->json([
                'status'=>1 ,
                'route'=>route('assessment.work.planned.index'),
                'message'=>__('admin.messages.success_add')
            ]);
        }catch(Exception $e){
            Log::critical("Error failed  storeInspectors assessment work : " . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param mixed $ids=[]
     * @param mixed $assessmentWorkId
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    private function setValuesToUsers($ids=[] , $assessmentWorkId)
    {
        try{
            $users = [];
            foreach($ids as $id)
            {
                $array = [
                    'assessment_work_planification_id'=> $assessmentWorkId ,
                    'user_id'=> $id
                ];
                array_push($users , $array);
            }
            return $users ;
        }catch(Exception $e){
            Log::critical("Error failed  setValuesToUsers assessment work : " . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param AssessmentWorkPlanification $assessment_work_planification
     *  @author saifeddin ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function show(AssessmentWorkPlanification $assessment_work_planification)
    {
        try{
         return view('assessment-work-planned.show',compact('assessment_work_planification' ));

        }catch(Exception $e){
            Log::critical("Error failed  show assessment work : " . $e->getMessage());
            abort(500);
        }

    }

     /**
     * get Assesement Work Planifications.
     *
     * @return void
     */
    public function getAssesementWorkPlanifications(Request $request)
    {
        $assessment_work_planifications = AssessmentWorkPlanification::query();

        if ($request->has('search') && !empty($request->search)) {
            $assessment_work_planifications->searchByReference($request->search);
        }

        if ($request->has('type') && !empty($request->type)) {
            $assessment_work_planifications->searchByKey('assessment_type_id', $request->type);
        }

        if ($request->has('user') && !empty($request->user)) {
            $assessment_work_planifications->searchByKey('user_id', $request->user);
        }

        if ($request->has('my_type') && !empty($request->my_type)) {
            $assessment_work_planifications->searchByKey('type', $request->my_type);
        }

        if ($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
            $assessment_work_planifications->searchBetweenDate($startDate,$endDate);
        }

        if ($request->has('cluster') && !empty($request->cluster)) {
            $offices =  $this->getOfficeByCluster((array)$request->cluster);
            $assessment_work_planifications->whereJsonContains('offices', $offices);
        }

        if ($request->has('facility') && !empty($request->facility)) {
            $offices =  $this->getOfficeByFacilite((array)$request->facility);
            $assessment_work_planifications->whereJsonContains('offices', $offices);

        }

        if ($request->has('building') && !empty($request->building)) {
            $offices =  $this->getOfficeByBuilding((array)$request->building);
            $assessment_work_planifications->whereJsonContains('offices', $offices);

        }

        if ($request->has('section') && !empty($request->section)) {
            $offices =  $this->getOfficeBySection((array)$request->section);
            $assessment_work_planifications->whereJsonContains('offices', $offices);

        }

        if ($request->has('office') && !empty($request->office)) {
            $assessment_work_planifications->whereJsonContains('offices', $request->office);
        }

        $view = view('assessment-work-planned.filter', [
            'assessment_work_planifications' => $assessment_work_planifications->paginate(self::NUMBER_PAGINATE),
        ]);

        return response()->json([
            'data' => $view->render(),
        ]);
    }

    /**
     * @return [type]
     *  @author saifeddine ghouma <saifgouma@gmail.com>
     */
    public function downloadModel()
    {
        try{
            return Excel::download(new AssessmentWorkPlannedExport, 'model_assessmentWork.xlsx');
             
    }catch(Exception $e){
         Log::critical("Error failed  download model excel : " . $e->getMessage());
        abort(500);
    }
    }

    /**
     * @param Request $request
     * @author saifeddine ghouma <saifgouma@gmail.com>
     * @return [type]
     */
    public function importDataExcel(Request $request)
    {
          try{
             $file = $this->uploadImageFile($request->file , 'errorsImport');
            Excel::queueImport(new ImportAssessmentWorkPlanned(auth()->user() , $file), $request->file);

             return response()->json([
                'status'=>1 ,
                'message'=>__('assessment-work.messages.import_has_successfully'),
                'class'=>"success",
                'route'=>route('assessment.work.planned.index')
            ],201) ; 
          }catch(Exception $e){
            Log::critical("Error failed  import data excel : " . $e->getMessage());
            return response()->json([
                'status'=>1 ,
                'message'=>'error',
                'class'=>"success"
            ],500) ; 
          }
    }
}
