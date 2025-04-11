<?php

namespace App\Observers;

use App\Http\Services\GenerateFile;
use App\Models\AssessmentWorkEvaluation;
use App\Traits\OfficeQueryTrait;

class AssessmentWorkEvaluationObserver
{
    use OfficeQueryTrait ;
    /**
     * Handle the AssessmentWorkEvaluation "created" event.
     */
    public function created(AssessmentWorkEvaluation $assessmentWorkEvaluation): void
    {
        $assessmentWork = $assessmentWorkEvaluation->assessmentWork;
        $totalToEvaluate = $assessmentWork->assessmentType->assessmentItems->count();
        $totalEvaluated = $assessmentWork->assessmentWorkEvaluations->count();
        if ($totalToEvaluate > $totalEvaluated) {
            $assessmentWork->status = 'pending';
        } else {
            $assessmentWork->status = 'finished';
            $geographicalArea = $this->getGeographicalDataByOffice($assessmentWork->office_id) ;

            $generate = new GenerateFile($assessmentWork);
            $view = view('reports.assessment-work-report', ['assessmentWork'=> $assessmentWork,'geographicalArea'=>$geographicalArea])->render();
             $generate->generatePdf('assessmentWork_' , $view , 'report');
        }
        $assessmentWork->save();
        
    }

    /**
     * Handle the AssessmentWorkEvaluation "updated" event.
     */
    public function updated(AssessmentWorkEvaluation $assessmentWorkEvaluation): void
    {
        //
    }

    /**
     * Handle the AssessmentWorkEvaluation "deleted" event.
     */
    public function deleted(AssessmentWorkEvaluation $assessmentWorkEvaluation): void
    {
        $assessmentWork = $assessmentWorkEvaluation->assessmentWork;
        $totalEvaluated = $assessmentWork->assessmentWorkEvaluations->count();

        if ($totalEvaluated == 0) {
            $assessmentWork->status = 'unstarted';
        } else {
            $assessmentWork->status = 'pending';
        }

        $assessmentWork->save();
    }

    /**
     * Handle the AssessmentWorkEvaluation "restored" event.
     */
    public function restored(AssessmentWorkEvaluation $assessmentWorkEvaluation): void
    {
        //
    }

    /**
     * Handle the AssessmentWorkEvaluation "force deleted" event.
     */
    public function forceDeleted(AssessmentWorkEvaluation $assessmentWorkEvaluation): void
    {
        //
    }
}
