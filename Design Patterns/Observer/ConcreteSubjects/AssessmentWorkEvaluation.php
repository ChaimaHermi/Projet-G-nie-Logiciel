<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentWorkEvaluation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'assessment_evaluations';

    protected $fillable = [
        'value',
        'notes',
        'pictures',
        'assessment_work_id',
        'evaluatable_id',
        'evaluatable_type'
    ];

    protected $casts = [
        'pictures' => 'array'
    ];



    /**
     * @author guedri abdessalem <abdessalem.guedri1@gmail.com>
     *
     * @return belongsTo
     */
    public function assessmentWork(): BelongsTo
    {
        return $this->belongsTo(AssessmentWork::class);
    }


    /**
     * @author guedri abdessalem <abdessalem.guedri1@gmail.com>
     *
     * @return MorphTo
     */
    public function evaluatable(): MorphTo
    {
        Relation::morphMap([
            'assessment_items' => AssessmentItems::class,
            'kpi_evaluations' => KpiEvaluation::class,
        ]);
        return $this->morphTo();
    }
}
