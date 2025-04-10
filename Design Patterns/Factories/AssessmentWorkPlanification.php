<?php

namespace App\Models;

use App\Concerns\SearchQueries;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AssessmentWorkPlanification extends Model
{
    use HasFactory , SoftDeletes , SearchQueries;
     protected $append = ['facility_name'] ;
    protected $fillable = [
       'offices','assessment_type_id','user_id', 'referance','status', 'notes' ,'type','date',
    ];

    protected $casts = [
        'offices' => 'array'
     ];

     /**
      * @return [type]
      */
    protected static function booted()
    {
        parent::boot();

        static::created(function ($data) {
            $data->referance = $data->generateReference();
            $data->save();
        });
    }
    /**
     * @param mixed $id
     *
     * @return [type]
     */
    public function generateReference()
    {
       return sprintf('Assessment-work-'.str_replace(' ','_',$this->assessmentType->getTranslation('name','en')).'-%s-%04u',
        now()->format('d-m-Y'),
        $this->orderBy('id','desc')->first()->id +1  ?? 1
    );
    }
    /**
     * @return [type]
     */
    public function user()
    {
         return $this->belongsTo(User::class);
    }

    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class);
    }
    /**
     * @return [type]
     */
    public function getFacilityNameAttribute()
    {
        if(empty($this->offices))
         return "--";
        $query =  DB::table('facilities')
                    ->join('buildings', 'buildings.facility_id', '=', 'facilities.id')
                    ->join('sections', 'buildings.id', '=', 'sections.building_id')
                    ->join('offices', 'sections.id', '=', 'offices.section_id')
                    ->whereIn('offices.id',$this->offices)
                    ->pluck('facilities.name')
                    ->first();
        if(!empty($query)){
            $name = json_decode($query ,true)[app()->getLocale()];
            return !empty($name) ? $name : '-';
        }
        return '-' ;

    }

    /**
     * @return [type]
     */
    public function getOffices()
    {
        $query = Office::whereIn('id',$this->offices)->get();
        return $query ;
    }

    /**
     * Search Assesment Work planification by reference
     *
     * @param Builder $query
     * @param [type] $reference
     * @return void
     */
    public function scopeSearchByReference(Builder $query, $reference)
    {
        return $query->where('referance', 'like', "%{$reference}%");
    }

    /**
     * Search Beetween date
     *
     * @param Builder $query
     * @param [type] $reference
     * @return void
     */
    public function scopeSearchBetweenDate(Builder $query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
