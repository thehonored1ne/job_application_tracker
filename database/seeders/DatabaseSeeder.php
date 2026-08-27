<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Enums\SalaryPeriod;
use App\Models\Company;
use App\Models\Contact;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin / test users
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
            ]
        );

        // Seed Companies & Contacts
        $companiesData = [
            [
                'name' => 'Stripe',
                'website' => 'https://stripe.com',
                'industry' => 'Fintech / Payments',
                'location' => 'San Francisco, CA / Remote',
                'notes' => 'High engineering bar, focus on API design, scalability and clean architecture.',
                'contacts' => [
                    [
                        'full_name' => 'Sarah Jenkins',
                        'role_title' => 'Senior Tech Recruiter',
                        'email' => 'sjenkins@example.com',
                        'linkedin_url' => 'https://linkedin.com/in/sarah-jenkins-talent',
                    ],
                ],
                'applications' => [
                    [
                        'job_title' => 'Staff Backend Engineer - Billing',
                        'job_url' => 'https://stripe.com/jobs/staff-backend-billing',
                        'employment_type' => EmploymentType::FullTime,
                        'location_type' => LocationType::Remote,
                        'location' => 'Remote US / Global',
                        'salary_min' => 180000,
                        'salary_max' => 220000,
                        'currency' => 'USD',
                        'salary_period' => SalaryPeriod::Yearly,
                        'status' => ApplicationStatus::TechnicalInterview,
                        'priority_rating' => 5,
                        'applied_date' => now()->subDays(18)->format('Y-m-d'),
                        'rounds' => [
                            [
                                'round_type' => RoundType::Screening,
                                'scheduled_at' => now()->subDays(12)->setHour(14)->setMinute(0),
                                'duration_minutes' => 30,
                                'meeting_url' => 'https://meet.google.com/str-tech-scr',
                                'interviewer_name' => 'Sarah Jenkins',
                                'interviewer_title' => 'Senior Tech Recruiter',
                                'prep_notes' => 'Discussed previous distributed systems experience and microservices background.',
                                'rating' => 5,
                                'status' => RoundStatus::Passed,
                            ],
                            [
                                'round_type' => RoundType::Technical,
                                'scheduled_at' => now()->addDays(2)->setHour(15)->setMinute(30),
                                'duration_minutes' => 60,
                                'meeting_url' => 'https://zoom.us/j/9876543210',
                                'interviewer_name' => 'Alex Rivera',
                                'interviewer_title' => 'Staff Systems Architect',
                                'prep_notes' => 'Review concurrency control, rate limiting, and idempotent webhooks.',
                                'status' => RoundStatus::Scheduled,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Shopify',
                'website' => 'https://shopify.com',
                'industry' => 'E-Commerce Platforms',
                'location' => 'Ottawa, Canada / Remote',
                'notes' => 'Digital by default culture, large scale Ruby & Go architectures.',
                'contacts' => [
                    [
                        'full_name' => 'David Chen',
                        'role_title' => 'Talent Acquisition Partner',
                        'email' => 'dchen@example.com',
                        'linkedin_url' => 'https://linkedin.com/in/davidchen-tech',
                    ],
                ],
                'applications' => [
                    [
                        'job_title' => 'Senior Full Stack Engineer',
                        'job_url' => 'https://shopify.com/careers/sr-full-stack',
                        'employment_type' => EmploymentType::FullTime,
                        'location_type' => LocationType::Remote,
                        'location' => 'Remote',
                        'salary_min' => 150000,
                        'salary_max' => 180000,
                        'salary_offered' => 175000,
                        'currency' => 'USD',
                        'salary_period' => SalaryPeriod::Yearly,
                        'status' => ApplicationStatus::OfferReceived,
                        'priority_rating' => 5,
                        'applied_date' => now()->subDays(30)->format('Y-m-d'),
                        'decision_date' => now()->subDays(2)->format('Y-m-d'),
                        'rounds' => [
                            [
                                'round_type' => RoundType::Screening,
                                'scheduled_at' => now()->subDays(25)->setHour(10)->setMinute(0),
                                'duration_minutes' => 45,
                                'status' => RoundStatus::Passed,
                                'rating' => 5,
                            ],
                            [
                                'round_type' => RoundType::Technical,
                                'scheduled_at' => now()->subDays(18)->setHour(14)->setMinute(0),
                                'duration_minutes' => 60,
                                'status' => RoundStatus::Passed,
                                'rating' => 5,
                            ],
                            [
                                'round_type' => RoundType::Final,
                                'scheduled_at' => now()->subDays(6)->setHour(16)->setMinute(0),
                                'duration_minutes' => 45,
                                'status' => RoundStatus::Passed,
                                'rating' => 5,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'GitHub',
                'website' => 'https://github.com',
                'industry' => 'Developer Tools',
                'location' => 'San Francisco, CA / Remote',
                'notes' => 'Async-first work culture, building for millions of developers.',
                'contacts' => [
                    [
                        'full_name' => 'Elena Rostova',
                        'role_title' => 'Engineering Lead',
                        'email' => 'elena@example.com',
                    ],
                ],
                'applications' => [
                    [
                        'job_title' => 'Senior Developer Experience Engineer',
                        'job_url' => 'https://github.com/about/careers',
                        'employment_type' => EmploymentType::FullTime,
                        'location_type' => LocationType::Remote,
                        'location' => 'Remote',
                        'salary_min' => 160000,
                        'salary_max' => 190000,
                        'currency' => 'USD',
                        'salary_period' => SalaryPeriod::Yearly,
                        'status' => ApplicationStatus::Applied,
                        'priority_rating' => 4,
                        'applied_date' => now()->subDays(4)->format('Y-m-d'),
                        'rounds' => [],
                    ],
                ],
            ],
            [
                'name' => 'Vercel',
                'website' => 'https://vercel.com',
                'industry' => 'Cloud Infrastructure / Frontend',
                'location' => 'San Francisco, CA / Remote',
                'notes' => 'Next.js & edge runtime creators.',
                'contacts' => [],
                'applications' => [
                    [
                        'job_title' => 'Solutions Engineer',
                        'job_url' => 'https://vercel.com/careers',
                        'employment_type' => EmploymentType::FullTime,
                        'location_type' => LocationType::Remote,
                        'location' => 'Remote',
                        'salary_min' => 140000,
                        'salary_max' => 170000,
                        'currency' => 'USD',
                        'salary_period' => SalaryPeriod::Yearly,
                        'status' => ApplicationStatus::Wishlist,
                        'priority_rating' => 3,
                        'applied_date' => null,
                        'rounds' => [],
                    ],
                ],
            ],
            [
                'name' => 'Cloudflare',
                'website' => 'https://cloudflare.com',
                'industry' => 'Security & CDN',
                'location' => 'Austin, TX / Hybrid',
                'notes' => 'Workers runtime, DDoS mitigation.',
                'contacts' => [
                    [
                        'full_name' => 'Marcus Vance',
                        'role_title' => 'Technical Recruiter',
                        'email' => 'mvance@example.com',
                    ],
                ],
                'applications' => [
                    [
                        'job_title' => 'Security Automation Engineer',
                        'job_url' => 'https://cloudflare.com/careers',
                        'employment_type' => EmploymentType::FullTime,
                        'location_type' => LocationType::Hybrid,
                        'location' => 'Austin, TX',
                        'salary_min' => 135000,
                        'salary_max' => 165000,
                        'currency' => 'USD',
                        'salary_period' => SalaryPeriod::Yearly,
                        'status' => ApplicationStatus::Screening,
                        'priority_rating' => 4,
                        'applied_date' => now()->subDays(10)->format('Y-m-d'),
                        'rounds' => [
                            [
                                'round_type' => RoundType::Screening,
                                'scheduled_at' => now()->addDays(1)->setHour(11)->setMinute(0),
                                'duration_minutes' => 30,
                                'meeting_url' => 'https://meet.google.com/cfl-scr-meet',
                                'interviewer_name' => 'Marcus Vance',
                                'interviewer_title' => 'Technical Recruiter',
                                'prep_notes' => 'Prepare overview of security incidents handled and CI/CD automated linting.',
                                'status' => RoundStatus::Scheduled,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($companiesData as $cData) {
            $company = Company::create([
                'name' => $cData['name'],
                'website' => $cData['website'] ?? null,
                'industry' => $cData['industry'] ?? null,
                'location' => $cData['location'] ?? null,
                'notes' => $cData['notes'] ?? null,
            ]);

            $createdContacts = [];
            foreach ($cData['contacts'] as $contactData) {
                $createdContacts[] = Contact::create([
                    'company_id' => $company->id,
                    'full_name' => $contactData['full_name'],
                    'role_title' => $contactData['role_title'] ?? null,
                    'email' => $contactData['email'] ?? null,
                    'phone' => $contactData['phone'] ?? null,
                    'linkedin_url' => $contactData['linkedin_url'] ?? null,
                    'notes' => $contactData['notes'] ?? null,
                ]);
            }

            $primaryContact = $createdContacts[0] ?? null;

            foreach ($cData['applications'] as $appData) {
                $application = JobApplication::create([
                    'company_id' => $company->id,
                    'contact_id' => $primaryContact?->id,
                    'job_title' => $appData['job_title'],
                    'job_url' => $appData['job_url'] ?? null,
                    'description' => $appData['description'] ?? 'Opportunity at '.$company->name,
                    'employment_type' => $appData['employment_type'] ?? EmploymentType::FullTime,
                    'location_type' => $appData['location_type'] ?? LocationType::Remote,
                    'location' => $appData['location'] ?? null,
                    'salary_min' => $appData['salary_min'] ?? null,
                    'salary_max' => $appData['salary_max'] ?? null,
                    'salary_offered' => $appData['salary_offered'] ?? null,
                    'currency' => $appData['currency'] ?? 'USD',
                    'salary_period' => $appData['salary_period'] ?? SalaryPeriod::Yearly,
                    'status' => $appData['status'] ?? ApplicationStatus::Applied,
                    'priority_rating' => $appData['priority_rating'] ?? 3,
                    'applied_date' => $appData['applied_date'] ?? null,
                    'decision_date' => $appData['decision_date'] ?? null,
                    'notes' => $appData['notes'] ?? null,
                ]);

                foreach ($appData['rounds'] ?? [] as $roundData) {
                    InterviewRound::create([
                        'job_application_id' => $application->id,
                        'round_type' => $roundData['round_type'] ?? RoundType::Screening,
                        'scheduled_at' => $roundData['scheduled_at'] ?? now(),
                        'duration_minutes' => $roundData['duration_minutes'] ?? 45,
                        'meeting_url' => $roundData['meeting_url'] ?? null,
                        'location' => $roundData['location'] ?? null,
                        'interviewer_name' => $roundData['interviewer_name'] ?? null,
                        'interviewer_title' => $roundData['interviewer_title'] ?? null,
                        'interviewer_email' => $roundData['interviewer_email'] ?? null,
                        'interviewer_linkedin' => $roundData['interviewer_linkedin'] ?? null,
                        'prep_notes' => $roundData['prep_notes'] ?? null,
                        'questions_asked' => $roundData['questions_asked'] ?? null,
                        'takeaways' => $roundData['takeaways'] ?? null,
                        'rating' => $roundData['rating'] ?? null,
                        'status' => $roundData['status'] ?? RoundStatus::Scheduled,
                    ]);
                }
            }
        }
    }
}
