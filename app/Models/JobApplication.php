<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\SalaryPeriod;
use Database\Factories\JobApplicationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    /** @use HasFactory<JobApplicationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'contact_id',
        'job_title',
        'job_url',
        'description',
        'employment_type',
        'location_type',
        'location',
        'salary_min',
        'salary_max',
        'salary_offered',
        'currency',
        'salary_period',
        'status',
        'priority_rating',
        'applied_date',
        'deadline_date',
        'decision_date',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'employment_type' => EmploymentType::class,
            'location_type' => LocationType::class,
            'salary_period' => SalaryPeriod::class,
            'status' => ApplicationStatus::class,
            'priority_rating' => 'integer',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'salary_offered' => 'decimal:2',
            'applied_date' => 'date',
            'deadline_date' => 'date',
            'decision_date' => 'date',
        ];
    }

    /**
     * Get the company that this application belongs to.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the primary contact for this application.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the interview rounds for this application.
     */
    public function interviewRounds(): HasMany
    {
        return $this->hasMany(InterviewRound::class);
    }

    /**
     * Scope a query to only include applications currently in interview stages.
     */
    public function scopeActiveInterviews(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ApplicationStatus::Screening,
            ApplicationStatus::TechnicalInterview,
            ApplicationStatus::BehavioralInterview,
            ApplicationStatus::FinalRound,
        ]);
    }

    /**
     * Scope a query to only include pending/active applications (not wishlist, not closed).
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ApplicationStatus::Applied,
            ApplicationStatus::Screening,
            ApplicationStatus::TechnicalInterview,
            ApplicationStatus::BehavioralInterview,
            ApplicationStatus::FinalRound,
            ApplicationStatus::OfferReceived,
        ]);
    }

    /**
     * Scope a query to only include officially submitted applications (non-wishlist).
     */
    public function scopeNonWishlist(Builder $query): Builder
    {
        return $query->where('status', '!=', ApplicationStatus::Wishlist);
    }

    /**
     * Scope a query to only include applications with a received or accepted offer.
     */
    public function scopeOffers(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ApplicationStatus::OfferReceived,
            ApplicationStatus::Accepted,
        ]);
    }

    /**
     * Scope a query to filter by a specific ApplicationStatus.
     */
    public function scopeStatus(Builder $query, ApplicationStatus|string $status): Builder
    {
        return $query->where('status', $status instanceof ApplicationStatus ? $status->value : $status);
    }

    /**
     * Scope a query to only include high priority applications (e.g. rating >= 4).
     */
    public function scopeHighPriority(Builder $query, int $minRating = 4): Builder
    {
        return $query->where('priority_rating', '>=', $minRating);
    }

    /**
     * Scope a query to order by most recently applied or created.
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('applied_date')->orderByDesc('created_at');
    }
}
