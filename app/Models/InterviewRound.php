<?php

namespace App\Models;

use App\Enums\RoundStatus;
use App\Enums\RoundType;
use Database\Factories\InterviewRoundFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewRound extends Model
{
    /** @use HasFactory<InterviewRoundFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_application_id',
        'round_type',
        'scheduled_at',
        'duration_minutes',
        'meeting_url',
        'location',
        'interviewer_name',
        'interviewer_title',
        'interviewer_email',
        'interviewer_linkedin',
        'prep_notes',
        'questions_asked',
        'takeaways',
        'rating',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'round_type' => RoundType::class,
            'status' => RoundStatus::class,
            'scheduled_at' => 'datetime',
            'duration_minutes' => 'integer',
            'rating' => 'integer',
        ];
    }

    /**
     * Get the job application that this round belongs to.
     */
    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }

    /**
     * Scope a query to only include upcoming scheduled interviews.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', RoundStatus::Scheduled)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc');
    }

    /**
     * Scope a query to only include past scheduled or completed rounds.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIn('status', [
            RoundStatus::Completed,
            RoundStatus::Passed,
            RoundStatus::Failed,
        ]);
    }
}
